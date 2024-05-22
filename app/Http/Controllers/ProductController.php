<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Company;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->json($request);
        }
        return view('product.index');
    }
    
    protected function json(Request $request) {
        $data = Product::with('company', 'category')->orderByDesc('created_at')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                return $data->is_active ? '<span class="badge badge-primary">active</span>':'<span class="badge badge-danger">non active</span>';
            })
            ->editColumn('action', function ($data) {
                $actionButton = '
                <a href='.route("product.edit", ['uuid' => $data->uuid]).' data-bs-toggle="tooltip" data-bs-placement="top" title="edit">
                    <i class="ki-duotone ki-pencil fs-5 text-warning"><span class="path1"></span><span class="path2"></span></i>
                </a>

                <a href='.route("product.delete", ['uuid' => $data->uuid]).' class="btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="delete">
                    <i class="ki-solid ki-trash fs-5 text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                </a>';
                return $actionButton;
            })
            ->editColumn('created_at', function ($data) {
                return formatDate($data->created_at);
            })
            ->editColumn('updated_at', function ($data) {
                return formatDate($data->updated_at);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::orderBy('name')->get();
        
        return view('product.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_uuid' => 'required|string',
            'category_uuid' => 'required|string',
            'name' => 'required|string|max:255',
            'price' => 'required|decimal:0,2',
            'description' => 'nullable|string',
            'is_active' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        DB::beginTransaction();
        try {
            $params = $validator->validate();
            $skuCode = Product::max('sku_code');
            $params['sku_code'] = $skuCode ? $skuCode + 1 : 100000;
            $params['is_active'] = $request->is_active ? 1 : 0;

            unset($params['images']);

            $product = Product::create($params);

            foreach($request->images as $item) {
                $image = upload($item, public_path('uploads/products/images/'));
                
                ProductImage::create([
                    'product_uuid' => $product->uuid,
                    'name' => $image,
                ]);
                
            }
            
            DB::commit();

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'saved data successfully',
            ], 200);
            

        } catch (\Throwable $th) {
            DB::rollBack();
            
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $uuid)
    {
        if($request->ajax()) {
            return $this->imageJson($uuid);
        }
        $data = Product::where('uuid', $uuid)->first();
        $companies = Company::orderBy('name')->get();
        $categories = Category::where('company_uuid', $data->company_uuid)->orderBy('name')->get();
        
        return view('product.edit', compact('data', 'companies', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'company_uuid' => 'required|string',
            'category_uuid' => 'required|string',
            'name' => 'required|string|max:255',
            'price' => 'required|decimal:0,2',
            'description' => 'nullable|string',
            'is_active' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        DB::beginTransaction();
        try {
            $params = $validator->validate();
            $params['is_active'] = $request->is_active ? 1 : 0;
            unset($params['images']);

            $images = ProductImage::where('product_uuid', $uuid)->whereNotIn('uuid', $request->product_image_uuid)->get();

            foreach($images as $item) {
                if(file_exists(public_path("uploads/products/images/$item->name"))) {
                    unlink(public_path("uploads/products/images/$item->name"));
                }
                $item->delete();
            }

            foreach($request->images as $item) {
                $image = upload($item, public_path('uploads/products/images/'));
                
                ProductImage::create([
                    'product_uuid' => $uuid,
                    'name' => $image,
                ]);
            }

            Product::where('uuid', $uuid)->update($params);
            
            DB::commit();

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'updated data successfully',
            ], 200);
            

        } catch (\Throwable $th) {
            DB::rollBack();
            
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        DB::beginTransaction();
        try {

            Product::where('uuid', $uuid)->delete();
            
            DB::commit();

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'deleted data successfully'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error',$th);
        }
    }

    protected function imageJson($uuid)
    {
        $data = ProductImage::where('product_uuid', $uuid)->orderByDesc('created_at')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('image', function ($data) {
                return '<img src="/uploads/products/images/' . $data->name . '" alt="image" height="50px" />';
            })
            ->editColumn('action', function ($data) {
                $actionButton = '
                <input type="hidden" name="product_image_uuid[]" value="'. $data->uuid .'">
                <a href='.route("product.image.delete", ['uuid' => $data->uuid]).' class="btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="delete">
                    <i class="ki-solid ki-trash fs-5 text-danger"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                </a>';
                return $actionButton;
            })
            ->editColumn('created_at', function ($data) {
                return formatDate($data->created_at);
            })
            ->editColumn('updated_at', function ($data) {
                return formatDate($data->updated_at);
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function imageDestroy($uuid)
    {
        DB::beginTransaction();
        try {

            $data = ProductImage::where('uuid', $uuid)->first();

            if(file_exists(public_path("uploads/products/image/$data->name"))) {
                unlink(public_path("uploads/products/image/$data->name"));
            }

            $data->delete();
            
            DB::commit();

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'deleted data successfully'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error',$th);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->json($request);
        }
        return view('category.index');
    }

    protected function json(Request $request) {
        $data = Category::with('company')
        ->when(auth()->user()->hasrole('merchant'), function($query) {
            $query->where('company_uuid', auth()->user()->company_uuid);
        })
        ->orderByDesc('created_at')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                return $data->is_active ? '<span class="badge badge-primary">active</span>':'<span class="badge badge-danger">non active</span>';
            })
            ->editColumn('action', function ($data) {
                $actionButton = '
                <a href='.route("category.edit", ['uuid' => $data->uuid]).' data-bs-toggle="tooltip" data-bs-placement="top" title="edit">
                    <i class="ki-duotone ki-pencil fs-5 text-warning"><span class="path1"></span><span class="path2"></span></i>
                </a>

                <a href='.route("category.delete", ['uuid' => $data->uuid]).' class="btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="delete">
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
        $companies = Company::when(auth()->user()->hasrole('merchant'), function($query) {
            $query->where('uuid', auth()->user()->company_uuid);
        })
        ->orderBy('name')->get();

        return view('category.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'company_uuid' => 'required|string',
            'is_active' => 'nullable|string',
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

            Category::create($params);
            
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
    public function edit($uuid)
    {
        $data = Category::where('uuid', $uuid)->first();
        $companies = Company::when(auth()->user()->hasrole('merchant'), function($query) {
            $query->where('uuid', auth()->user()->company_uuid);
        })
        ->orderBy('name')->get();

        return view('category.edit', compact('data', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'company_uuid' => 'required|string',
            'is_active' => 'nullable|string',
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
            
            Category::where('uuid', $uuid)->update($params);
            
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

            Category::where('uuid', $uuid)->delete();
            
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

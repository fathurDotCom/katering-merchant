<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Province;
use App\Models\Subdistrict;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->json($request);
        }

        return view('company.index');
    }
    
    protected function json(Request $request) {
        $data = Company::when(auth()->user()->hasrole('merchant'), function($query) {
            $query->where('uuid', auth()->user()->company_uuid);
        })->orderByDesc('created_at')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                return $data->is_active ? '<span class="badge badge-primary">active</span>':'<span class="badge badge-danger">non active</span>';
            })
            ->editColumn('action', function ($data) {
                $actionButton = '
                <a href='.route("company.edit", ['uuid' => $data->uuid]).' data-bs-toggle="tooltip" data-bs-placement="top" title="edit">
                    <i class="ki-duotone ki-pencil fs-5 text-warning"><span class="path1"></span><span class="path2"></span></i>
                </a>

                <a href='.route("company.delete", ['uuid' => $data->uuid]).' class="btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="delete">
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
    public function create(Request $request)
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|string',
            'phone' => 'required|string',
            'email' => 'nullable|string',
            'url' => 'nullable|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'youtube' => 'nullable|string',
            'twitter' => 'nullable|string',
            'address' => 'nullable|string',
            'logo_light' => 'required|image|mimes:jpg,jpeg,png',
            'logo_dark' => 'required|image|mimes:jpg,jpeg,png',
            'favicon' => 'required|image|mimes:jpg,jpeg,png,svg',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
    
            // Mengubah errors menjadi format teks
            $errorMessages = $errors->all();
            $formattedErrors = implode("<br>- ", $errorMessages);
            
            // Tambahkan tanda dash di awal
            $formattedErrors = '- ' . $formattedErrors;

            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => $formattedErrors,
            ], 400);
        }

        DB::beginTransaction();
        try {
            $params = $validator->validate();
            $params['is_active'] = $request->is_active ? 1 : 0;
            $params['logo_light'] = upload($params['logo_light'], public_path('uploads/companies/logos/'));
            $params['logo_dark'] = upload($params['logo_dark'], public_path('uploads/companies/logos/'));
            $params['favicon'] = upload($params['favicon'], public_path('uploads/companies/logos/'));
            
            $company = Company::create($params);

            User::where('uuid', auth()->user()->uuid)->update([
                'company_uuid' => $company->uuid,
            ]);
            
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
                'message' => json_encode($th->getMessage()),
            ], 500);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $uuid)
    {
        $data = Company::where('uuid', $uuid)->first();

        return view('company.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|string',
            'phone' => 'required|string',
            'email' => 'nullable|string',
            'url' => 'nullable|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'youtube' => 'nullable|string',
            'twitter' => 'nullable|string',
            'address' => 'nullable|string',
            'logo_light' => 'nullable|image|mimes:jpg,jpeg,png',
            'logo_dark' => 'nullable|image|mimes:jpg,jpeg,png',
            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,svg',
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
            $company =  Company::where('uuid', $uuid)->first();
            $params['is_active'] = $request->is_active ? 1 : 0;

            if($request->logo_light) {
                if(file_exists(public_path("uploads/companies/logos/$company->logo_light"))) {
                    unlink(public_path("uploads/companies/logos/$company->logo_light"));
                }
                $params['logo_light'] = upload($params['logo_light'], public_path('uploads/companies/logos/'));
            }
            if($request->logo_dark) {
                if(file_exists(public_path("uploads/companies/logos/$company->logo_dark"))) {
                    unlink(public_path("uploads/companies/logos/$company->logo_dark"));
                }
                $params['logo_dark'] = upload($params['logo_dark'], public_path('uploads/companies/logos/'));
            }
            if($request->favicon) {
                if(file_exists(public_path("uploads/companies/logos/$company->favicon"))) {
                    unlink(public_path("uploads/companies/logos/$company->favicon"));
                }
                $params['favicon'] = upload($params['favicon'], public_path('uploads/companies/logos/'));
            }
            
            $company->update($params);
            
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
    public function destroy(Request $request, $uuid)
    {
        DB::beginTransaction();
        try {
            
            $data = Company::where('uuid', $uuid)->delete();
            
            DB::commit();

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'deleted data successfully'
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error',$th->getMessage());
        }
    }
}

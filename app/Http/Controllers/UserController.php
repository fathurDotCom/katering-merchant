<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->json($request);
        }

        return view('user.index');
    }

    protected function json() {
        $data = User::with('company')
        ->when(auth()->user()->hasrole('merchant'), function ($query) {
            $query->where('company_uuid', auth()->user()->company_uuid);
        })
        ->orderByDesc('created_at')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('fullname', function ($data) {
                return $data->firstname . ' ' . $data->lastname;
            })
            ->editColumn('status', function ($data) {
                return $data->is_active ? '<span class="badge badge-primary">active</span>':'<span class="badge badge-danger">non active</span>';
            })
            ->editColumn('action', function ($data) {
                $actionButton = '
                <a href='.route("user.edit", $data->uuid).' data-bs-toggle="tooltip" data-bs-placement="top" title="edit">
                    <i class="ki-duotone ki-pencil fs-5 text-warning"><span class="path1"></span><span class="path2"></span></i>
                </a>

                <a href='.route("user.delete", $data->uuid).' class="btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="delete">
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
        $companies = Company::get();
        return view('user.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string|max:255',
            'company_uuid' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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
            $params['password'] = Hash::make($params['password']);
            if($request->photo) {
                $params['photo'] = upload($params['photo'], public_path('uploads/users/photos/'));
            }

            $data = User::create($params);

            if ($data) {
                $data->assignRole('merchant');
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
        $data = User::where('uuid', $uuid)->first();
        $companies = Company::get();

        return view('user.edit', compact('data', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $data = User::where('uuid', $uuid)->first();
        
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,'.$data->id,
            'password' => 'nullable|string|max:255',
            'company_uuid' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
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
            if(@$params['photo']) {
                if(file_exists(public_path("uploads/users/photos/$data->photo"))) {
                    unlink(public_path("uploads/users/photos/$data->photo"));
                }
                $params['photo'] = upload($params['photo'], public_path('uploads/users/photos/'));
            }
            if($request->password) {
                $params['password'] = Hash::make($params['password']);
            } else {
                unset($params['password']);
            }
            
            $data->update($params);

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
            
            $data = User::where('uuid', $uuid)->delete();

            DB::commit();

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'deleted data successfully',
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
}

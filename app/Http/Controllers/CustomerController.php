<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->json($request);
        }
        return view('customer.index');
    }

    protected function json() {
        $data = User::join('orders', 'users.uuid', 'orders.customer_uuid')
        ->join('companies', 'orders.company_uuid', 'companies.uuid')
        ->when(auth()->user()->hasrole('merchant'), function($query) {
            $query->where('companies.uuid', auth()->user()->company_uuid);
        })
        ->role('user')
        ->select('users.*', 'companies.name as company_name')
        ->groupBy('users.uuid', 'companies.name')
        ->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('fullname', function ($data) {
                return $data->firstname . ' ' . $data->lastname;
            })
            ->escapeColumns([])
            ->make(true);
    }
}

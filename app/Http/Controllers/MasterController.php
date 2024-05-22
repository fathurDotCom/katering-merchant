<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function companies(Request $request)
    {
        $company = Company::where('uuid', $request->company_uuid)->select('country_uuid', 'province_uuid', 'city_uuid', 'district_uuid', 'subdistrict_uuid', 'url', 'facebook', 'instagram', 'youtube', 'twitter')->first();

        return $company;
    }

    public function categories(Request $request)
    {
        $categories = Category::where('company_uuid', $request->company_uuid)->orderBy('name')->get();
        
        $html = '<option></option>';
        foreach($categories as $item) {
            $html .= '<option value="'.$item->uuid.'">'.$item->name.'</option>';
        }

        return $html;
    }

    public function customers(Request $request)
    {
        $customers = User::role('user')->get();
        
        $html = '<option></option>';
        foreach($customers as $item) {
            $html .= '<option value="'.$item->uuid.'">' . $item->firstname . ' '. $item->lastname . '</option>';
        }

        return $html;
    }

    public function products(Request $request)
    {
        $products = Product::where('company_uuid', $request->company_uuid)->orderBy('name')->get();
        
        $html = '<option></option>';
        foreach($products as $item) {
            $html .= '<option value="'.$item->uuid.'">'.$item->name.' - ' . $item->price . '</option>';
        }

        return $html;
    }
}

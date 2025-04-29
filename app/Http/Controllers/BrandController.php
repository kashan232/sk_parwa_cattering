<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{

    public function brand()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $all_brand = Brand::get();
               
                return view('admin_panel.brand.brand', [
                    'all_brand' => $all_brand
                ]);
        } else {
            return redirect()->back();
        }
    }
    public function store_brand(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            Brand::create([
                'admin_or_user_id'    => $userId,
                'brand'             => $request->brand,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'brand Added Successfully');
        } else {
            return redirect()->back();
        }
    }
    public function update_brand(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            // dd($reques   t);
            $update_id = $request->input('brand_id');
            $brand = $request->input('brand_name');

            Brand::where('id', $update_id)->update([
                'brand'   => $brand,
                'updated_at' => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'Category Updated Successfully');
        } else {
            return redirect()->back();
        }
    }
}

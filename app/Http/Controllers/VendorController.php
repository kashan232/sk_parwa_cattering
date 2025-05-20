<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\VendorOrderAssign;
use Carbon\Carbon;

class VendorController extends Controller
{
    public function vendor()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId); 
            $Vendors = Vendor::get();
            return view('admin_panel.vendor.vendors', [
                'Vendors' => $Vendors
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function store_vendor(Request $request)
    {
        // dd($request->toArray());
        $lastvendor = Vendor::latest('id')->first(); // Last customer ka ID find karega
        $nextId = $lastvendor ? $lastvendor->id + 1 : 1; // Agar koi customer nahi mila toh 1 set karega

        // dd('CUST-' . str_pad($nextId, 4, '0', STR_PAD_LEFT));
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            Vendor::create([
                'name'          => $request->vendor_name,
                'phone'          => $request->vendor_phone,
                'address'          => $request->vendor_address,
                'identity'          => 'Vend-' . str_pad($nextId, 4, '0', STR_PAD_LEFT),
            ]);
            return redirect()->back()->with('success', 'Vendor has been  created successfully');
        } else {
            return redirect()->back();
        }
    }
    public function update_vendor(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            // dd($request);
            $vendor_id =  $request->vendor_id;
            Vendor::where('id', $vendor_id)->update([
                'name'          => $request->vendor_name,
                'phone'          => $request->vendor_phone,
                'address'          => $request->vendor_address,
            ]);
            return redirect()->back()->with('success', 'Customer Updated Successfully');
        } else {
            return redirect()->back();
        }
    }

    public function give_order_to_vendor()
    {
        if (Auth::id()) {
            $userId = Auth::id();
    
            $Vendors = Vendor::get();
            $orders = Order::where('order_status', 'confirmed')
                ->where(function($q) {
                    $q->whereNull('assign_status')
                      ->orWhere('assign_status', 'Pending');
                })->get();
    
            return view('admin_panel.vendor.give_vendor_order', [
                'Vendors' => $Vendors,
                'orders' => $orders
            ]);
        } else {
            return redirect()->back();
        }
    }
    

   
}

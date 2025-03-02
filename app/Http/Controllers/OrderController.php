<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function all_order()
    {

        // dd("Ad");
        if (Auth::id()) {
            $userId = Auth::id();
            // $all_unit = Unit::where('admin_or_user_id', '=', $userId)->get();
            // $all_product = Product::get();
            $orders = Order::get();

            
            return view('admin_panel\order\all_order',compact('orders'));
        } else {
            return redirect()->back();
        }
    }

    public function add_order()
    {

        dd("Ad");
        if (Auth::id()) {
            $userId = Auth::id();
            // $all_unit = Unit::where('admin_or_user_id', '=', $userId)->get();
            $all_product = Product::get();
            $all_customer = Customer::get();

            
            return view('admin_panel\order\all_order',compact('all_product', 'all_customer'));
        } else {
            return redirect()->back();
        }
    }

    public function all_order_item()
    {

        // dd("Aad");
        if (Auth::id()) {
            $userId = Auth::id();
            // $all_unit = Unit::where('admin_or_user_id', '=', $userId)->get();
            $order_items = OrderItem::with('product')->get();
            // dd($order_items->toArray());
            
            return view('admin_panel\order\all_order_items',compact('order_items'));
        } else {
            return redirect()->back();
        }
    }



}

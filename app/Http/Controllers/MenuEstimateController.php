<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\MenuEstimate;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuEstimateController extends Controller
{
    
    public function all_menu()
    {

        // dd("Ad");
        if (Auth::id()) {
            $userId = Auth::id();
            $orders = MenuEstimate::where('user_id', '=', $userId)->get();
            return view('admin_panel.menu_estimate.all_order', compact('orders'));
        } else {
            return redirect()->back();
        }
    }

    public function add_menu()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // $all_unit = Unit::where('admin_or_user_id', '=', $userId)->get();
            $all_product = Product::get();
            $Customers = Customer::get();
            $Category = Category::get();

            return view('admin_panel.menu_estimate.add_order', compact('all_product', 'Customers', 'Category'));
        } else {
            return redirect()->back();
        }
    }

    public function store_menu(Request $request)
    {
        if (Auth::id()) {
            $userId = Auth::id();

            // Total price aur payable amount calculate karna
            $totalPrice = $request->input('total_price', 0);
            $discount = $request->input('discount', 0);
            $payableAmount = $totalPrice - $discount;

            // Order ka array prepare karna
            $orderData = [
                'user_id' => $userId,
                'customer_name' => $request->input('customer_name'),
                'sale_date' => $request->input('sale_date', ''),
                'delivery_date' => $request->input('delivery_date', ''),
                'event_type' => $request->input('event_type', ''),
                'food_type' => $request->input('food_type', ''),
                'Venue' => $request->input('Venue', ''),
                'person_program' => $request->input('person_program', ''),
                'item_category' => json_encode($request->input('item_category', [])),
                'item_subcategory' => json_encode($request->input('item_subcategory', [])),
                'item_name' => json_encode($request->input('item_name', [])),
                'unit' => json_encode($request->input('unit', [])),
                'quantity' => json_encode($request->input('quantity', [])),
                'price' => json_encode($request->input('price', [])),
                'total' => json_encode($request->input('total', [])),
                'total_price' => $totalPrice,
            ];

            // Order create karna
            MenuEstimate::create($orderData);

            return redirect()->back()->with('success', 'Order successfully saved!');
        } else {
            return redirect()->back()->with('error', 'Unauthorized access!');
        }
    }

    public function show($id)
    {
        $order = MenuEstimate::findOrFail($id);

        return view('admin_panel.menu_estimate.invoice', compact('order'));
    }

}

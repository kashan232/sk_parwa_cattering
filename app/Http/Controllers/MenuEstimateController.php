<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\MenuEstimate;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuEstimateController extends Controller
{

    public function all_menu()
    {

        // dd("Ad");
        if (Auth::id()) {
            $userId = Auth::id();
            $orders = MenuEstimate::get();
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
                'mobile_number' => $request->input('mobile_number', ''),
                'reference_name' => $request->input('reference_name', ''),
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
        $categories = $order->subcategories(); // Yeh humein collection dega
        $categoriesMap = $categories->pluck('name', 'category_id')->toArray();

        return view('admin_panel.menu_estimate.invoice', compact('order', 'categoriesMap'));
    }

    
    public function confirmOrder(Request $request)
    {
        $estimateId = $request->estimate_id;

        DB::beginTransaction();

        try {
            // Find estimate
            $estimate = MenuEstimate::findOrFail($estimateId);

            // Directly create new order, no check for existing orders
            $order = new Order();
            $order->user_id = $estimate->user_id;
            $order->customer_name = $estimate->customer_name;
            $order->sale_date = $estimate->sale_date;
            $order->delivery_date = $estimate->delivery_date;
            $order->event_type = $estimate->event_type;
            $order->Venue = $estimate->Venue;
            $order->person_program = $estimate->person_program;
            $order->item_category = $estimate->item_category;
            $order->item_subcategory = $estimate->item_subcategory;
            $order->item_name = $estimate->item_name;
            $order->unit = $estimate->unit;
            $order->quantity = $estimate->quantity;
            $order->price = $estimate->price;
            $order->total = $estimate->total;
            $order->total_price = $estimate->total_price;

            // Default values
            $order->order_name = null;
            $order->delivery_time = null;
            $order->special_instructions = null;
            $order->note = null;
            $order->discount = 0;
            $order->payable_amount = $estimate->total_price;
            $order->advance_paid = 0;
            $order->remaining_amount = $estimate->total_price;
            $order->order_status = 'confirmed';
            $order->payment_status = 'pending';
            $order->order_type = 'menu';

            $order->save();

            // Update estimate status to "Confirmed" (you were using 1, that's fine if 1 means Confirmed in your system)
            $estimate->status = '1';
            $estimate->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order confirmed successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $order = MenuEstimate::findOrFail($id);

        // Decode the stored category and subcategory IDs
        $categoryIds = json_decode($order->item_category, true);
        $subcategoryIds = json_decode($order->item_subcategory, true);

        // Fetch their names
        $categoryNames = Category::whereIn('id', $categoryIds)->pluck('category')->toArray();
        $subcategoryNames = Subcategory::whereIn('id', $subcategoryIds)->pluck('name')->toArray();

        $productIds = json_decode($order->item_name);

        // Other data
        $all_product = Product::get();
        $Customers = Customer::get();
        $Category = Category::get();

        return view('admin_panel.menu_estimate.edit_estimate', compact(
            'all_product',
            'Customers',
            'Category',
            'order',
            'categoryNames',
            'subcategoryNames'
        ));
    }

    public function update_menu(Request $request, $id)
    {
        if (Auth::id()) {
            $userId = Auth::id();

            // Total price aur payable amount calculate karna
            $totalPrice = $request->input('total_price', 0);
            $discount = $request->input('discount', 0);
            $payableAmount = $totalPrice - $discount;

            // Record ko find karna
            $order = MenuEstimate::findOrFail($id);

            // Update data
            $order->update([
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
            ]);

            return redirect()->back()->with('success', 'Order successfully updated!');
        } else {
            return redirect()->back()->with('error', 'Unauthorized access!');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Customer;
use App\Models\GatePass;
use App\Models\GatePassItem;
use App\Models\KitchenInventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Riskihajar\Terbilang\Facades\Terbilang;

class OrderController extends Controller
{
    public function all_order()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $orders = Order::with('vendorOrderAssign.vendor')->get();
            return view('admin_panel.order.all_order', compact('orders'));
        } else {
            return redirect()->back();
        }
    }

    public function add_order()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // $all_unit = Unit::where('admin_or_user_id', '=', $userId)->get();
            $all_product = Product::get();
            $Customers = Customer::get();
            $Category = Category::get();

            return view('admin_panel.order.add_order', compact('all_product', 'Customers', 'Category'));
        } else {
            return redirect()->back();
        }
    }

    public function store_order(Request $request)
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // Customer Info split karna (ID | Name)
            $customerData = explode('|', $request->customer_info);
            $customerId = $customerData[0];
            $customerName = $customerData[1];

            // Total price aur payable amount calculate karna
            $totalPrice = $request->input('total_price', 0);
            $discount = $request->input('discount', 0);
            $payableAmount = $totalPrice - $discount;

            // Advance Paid and Remaining Amount
            $advancePaid = $request->input('advance_paid', 0);
            $remainingAmount = $payableAmount - $advancePaid;

            // Order ka array prepare karna
            $orderData = [
                'user_id' => $userId,
                'customer_id' => $customerId,
                'customer_name' => $customerName,
                'sale_date' => $request->input('sale_date', ''),
                'order_name' => $request->input('order_name', ''),
                'delivery_date' => $request->input('delivery_date', ''),
                'delivery_time' => $request->input('delivery_time', ''),
                'event_type' => $request->input('event_type', ''),
                'Venue' => $request->input('Venue'),
                'person_program' => $request->input('person_program'),
                'order_status' => 'Pending',
                'special_instructions' => $request->input('special_instructions', ''),
                'note' => $request->input('note', ''),
                'item_category' => json_encode($request->input('item_category', [])),
                'item_subcategory' => json_encode($request->input('item_subcategory', [])),
                'item_name' => json_encode($request->input('item_name', [])),
                'unit' => json_encode($request->input('unit', [])),
                'quantity' => json_encode($request->input('quantity', [])),
                'price' => json_encode($request->input('price', [])),
                'total' => json_encode($request->input('total', [])),
                'total_price' => $totalPrice,
                'discount' => $discount,
                'payable_amount' => $payableAmount,
                'advance_paid' => $advancePaid,
                'remaining_amount' => $remainingAmount,
                'payment_status' => 'Unpaid',
                'order_type' => 'System Order',
            ];

            // Order create karna
            Order::create($orderData);

            return redirect()->back()->with('success', 'Order successfully saved!');
        } else {
            return redirect()->back()->with('error', 'Unauthorized access!');
        }
    }

    public function show($id)
    {
        $order = Order::with('Customer')->findOrFail($id);

        return view('admin_panel.order.invoice', compact('order'));
    }

    public function show_voucher($id)
    {
        $order = Order::with('Customer')->findOrFail($id);
        $orderPayments = DB::table('order_payments')
            ->where('order_id', $id)
            ->orderBy('payment_date', 'asc')
            ->get();

        $amountInWords = ucwords(Terbilang::make($order->payable_amount)) . ' Only';

        return view('admin_panel.order.show_voucher', compact('order', 'amountInWords', 'orderPayments'));
    }


    public function paymentUpdate(Request $request)
    {
        $order = Order::find($request->order_id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found!']);
        }

        $paidAmount = $request->input('paid_amount', 0);
        $purpose = $request->input('purpose', 'Payment Received');

        $newAdvancePaid = $order->advance_paid + $paidAmount;
        $newRemainingAmount = $order->remaining_amount - $paidAmount;

        // Payment status update
        $paymentStatus = ($newRemainingAmount <= 0) ? "Paid" : "Unpaid";

        // Order update
        $order->update([
            'advance_paid' => $newAdvancePaid,
            'remaining_amount' => $newRemainingAmount,
            'payment_status' => $paymentStatus
        ]);

        // Insert record in order_payments table
        OrderPayments::create([
            'order_id' => $order->id,
            'paid_amount' => $paidAmount,
            'payment_date' => now(),
            'purpose' => $purpose,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Payment updated and recorded successfully!']);
    }

    public function save_order(Request $request)
    {
        // `items` array extract karna
        $items = $request->input('items', []);

        // Alag-alag fields ke liye values extract karna
        $itemCategories = [];
        $itemSubcategories = [];
        $itemNames = [];
        $units = [];
        $quantities = [];
        $prices = [];
        $totals = [];

        foreach ($items as $item) {
            $itemCategories[] = $item['item_category'] ?? '';
            $itemSubcategories[] = $item['item_subcategory'] ?? '';

            // Item name clean karna (category/subcategory aur \n hata kar)
            $cleanedItemName = preg_replace('/\s*\(.*?\)|\n.*/', '', $item['item_name'] ?? '');
            $cleanedItemName = trim($cleanedItemName);

            $itemNames[] = $cleanedItemName;
            $units[] = $item['unit'] ?? '';
            $quantities[] = $item['quantity'] ?? 0;
            $prices[] = $item['price'] ?? 0;
            $totals[] = $item['total'] ?? 0;
        }


        $orderData = [
            'customer_name' => $request->input('client_name'),
            'sale_date' => $request->input('sale_date', now()),
            'order_name' => $request->input('order_name', ''),
            'delivery_date' => $request->input('program_date', ''),
            'delivery_time' => $request->input('delivery_time', ''),
            'venue' => $request->input('venue', ''),
            'person_program' => $request->input('person_program', ''),
            'special_instructions' => $request->input('special_instructions', ''),
            'note' => $request->input('note', ''),
            'item_category' => json_encode($itemCategories),
            'item_subcategory' => json_encode($itemSubcategories),
            'item_name' => json_encode($itemNames),
            'unit' => json_encode($units),
            'quantity' => json_encode($quantities),
            'price' => json_encode($prices),
            'total' => json_encode($totals),
            'total_price' => $request->input('total_price', 0),
            'discount' => $request->input('discount', 0),
            'payable_amount' => $request->input('total_price', 0),
            'advance_paid' => $request->input('advance_paid', 0),
            'remaining_amount' => $request->input('total_price', 0),
            'order_status' => 'Pending',
            'payment_status' => 'Unpaid',
            'order_type' => 'Online Order',
        ];

        $order = Order::create($orderData);

        return response()->json([
            'success' => true,
            'message' => 'Order saved successfully!',
            'order_id' => $order->id
        ]);
    }

    public function online_order()
    {

        // dd("Ad");
        if (Auth::id()) {
            $userId = Auth::id();
            $orders = Order::where('order_type', '=', 'Online Order')->get();
            return view('admin_panel.order.online_order', compact('orders'));
        } else {
            return redirect()->back();
        }
    }


    public function getOrderInventory(Order $order)
    {
        $inventoryItems = KitchenInventory::with('item')
            ->get()
            ->map(function ($inventory) {
                return [
                    'id' => $inventory->item->id ?? null,
                    'name' => $inventory->item->name ?? 'N/A',
                    'quantity' => $inventory->quantity,
                ];
            });

        return response()->json($inventoryItems);
    }


    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'inventory' => 'required|array',
            'inventory.*' => 'numeric|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Gate Pass create
            $gatePass = GatePass::create([
                'order_id' => $request->order_id,
                'status' => 'pending',
            ]);

            foreach ($request->inventory as $itemId => $quantity) {
                // Inventory check
                $inventory = KitchenInventory::where('item_id', $itemId)->first();
                if (!$inventory || $inventory->quantity < $quantity) {
                    return back()->with('error', "Insufficient stock for item ID: $itemId");
                }

                // Inventory minus
                $inventory->decrement('quantity', $quantity);

                // Gate Pass Items create
                GatePassItem::create([
                    'gate_pass_id' => $gatePass->id,
                    'item_id' => $itemId,
                    'quantity' => $quantity,
                ]);
            }

            DB::commit();
            return back()->with('success', 'Gate Pass Generated Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function get_passes()
    {

        // dd("Ad");
        if (Auth::id()) {
            $userId = Auth::id();
            $gatePasses = GatePass::get();
            return view('admin_panel.order.get_passes', compact('gatePasses'));
        } else {
            return redirect()->back();
        }
    }

    public function getGatePassInventory($id)
    {
        $gatePass = GatePass::with('items.item')->findOrFail($id);
        $items = $gatePass->items->map(function ($gpItem) {
            return [
                'item_id' => $gpItem->item_id,
                'name' => $gpItem->item->name,
                'quantity' => $gpItem->quantity
            ];
        });

        return response()->json($items);
    }

    public function returnGatePass(Request $request)
    {
        $request->validate([
            'gate_pass_id' => 'required|exists:gate_passes,id',
            'return_inventory' => 'required|array',
            'return_inventory.*' => 'numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $gatePass = GatePass::with('items')->findOrFail($request->gate_pass_id);

            if ($gatePass->status == 'returned') {
                return back()->with('error', 'This Gate Pass has already been returned.');
            }

            foreach ($request->return_inventory as $itemId => $returnQty) {
                if ($returnQty > 0) {
                    $gatePassItem = $gatePass->items->where('item_id', $itemId)->first();

                    if ($gatePassItem && $returnQty <= $gatePassItem->quantity) {
                        // Kitchen Inventory me quantity wapas add karo
                        KitchenInventory::where('item_id', $itemId)->increment('quantity', $returnQty);
                    } else {
                        return back()->with('error', 'Invalid return quantity for item ID: ' . $itemId);
                    }
                }
            }

            // Gate Pass ka status update karo
            $gatePass->update(['status' => 'returned']);

            DB::commit();
            return back()->with('success', 'Gate Pass Returned Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}

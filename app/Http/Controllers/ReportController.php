<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderPayments;
use App\Models\Purchase;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function customer_report()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            $Customers = Customer::get();
            return view('admin_panel.reporting.customer_report', [
                'Customers' => $Customers,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function getCustomerReportData($id)
    {
        $orders = Order::where('customer_id', $id)->get();

        $total_orders = $orders->count();
        $delivered = $orders->where('order_status', 'Delivered')->count();
        $pending = $orders->where('order_status', 'Pending')->count();
        $cancelled = $orders->where('order_status', 'Cancelled')->count();
        $confirmed = $orders->where('order_status', 'confirmed')->count();
        $preparing = $orders->where('order_status', 'Preparing')->count();

        $total_payable = $orders->sum('payable_amount');
        $orderIds = $orders->pluck('id');
        $total_paid = OrderPayments::whereIn('order_id', $orderIds)->sum('paid_amount');

        return response()->json([
            'total_orders' => $total_orders,
            'delivered' => $delivered,
            'pending' => $pending,
            'cancelled' => $cancelled,
            'confirmed' => $confirmed,
            'preparing' => $preparing,
            'total_payable' => $total_payable,
            'total_paid' => $total_paid,
        ]);
    }



    public function order_report()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            return view('admin_panel.reporting.order-report', []);
        } else {
            return redirect()->back();
        }
    }

    public function filter_order_report(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $orders = Order::whereBetween('sale_date', [$start_date, $end_date])
            ->get();

        $graphData = [];

        // Totals
        $total_payable = 0;
        $total_paid = 0;
        $total_remaining = 0;

        foreach ($orders as $order) {
            $date = Carbon::parse($order->sale_date)->format('Y-m-d');

            if (!isset($graphData[$date])) {
                $graphData[$date] = [
                    'Delivered' => 0,
                    'Pending' => 0,
                    'Preparing' => 0,
                    'Cancelled' => 0,
                    'Total' => 0,
                ];
            }

            $status = strtolower($order->order_status);

            if ($status === 'delivered') $graphData[$date]['Delivered']++;
            elseif ($status === 'pending' || $status === 'confirmed') $graphData[$date]['Pending']++;
            elseif ($status === 'preparing') $graphData[$date]['Preparing']++;
            elseif ($status === 'cancelled') $graphData[$date]['Cancelled']++;

            $graphData[$date]['Total']++;

            // Totals
            $total_payable += $order->payable_amount;
            $total_paid += $order->advance_paid;
            $total_remaining += ($order->payable_amount - $order->advance_paid);
        }

        return response()->json([
            'orders' => $orders,
            'graphData' => $graphData,
            'totals' => [
                'total_orders' => $orders->count(),
                'total_payable' => $total_payable,
                'total_paid' => $total_paid,
                'total_remaining' => $total_remaining,
            ],
        ]);
    }


    public function purchase_report()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            return view('admin_panel.reporting.purchase-report', []);
        } else {
            return redirect()->back();
        }
    }
    public function filterpurchase(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $purchase = Purchase::whereBetween('purchase_date', [$start_date, $end_date])
            ->orderBy('purchase_date', 'asc')
            ->get();

        // Check if data is being retrieved
        return response()->json($purchase); // This should return a JSON response
    }

    public function vendor_report()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            $Vendors = Vendor::get();
            return view('admin_panel.reporting.vendor_report', [
                'Vendors' => $Vendors,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function getVendorReport(Request $request)
    {
        $vendorId = $request->vendor_id;

        $vendor = Vendor::findOrFail($vendorId);

        // Get vendor ledger entries with assigned item info
        $ledgerEntries = DB::table('vendor_ledgers as vl')
            ->join('orders as o', 'o.id', '=', 'vl.order_id')
            ->join('vendor_order_assigns as voa', function ($join) {
                $join->on('voa.order_id', '=', 'vl.order_id')
                    ->on('voa.vendor_id', '=', 'vl.vendor_id')
                    ->on('voa.item_id', '=', 'vl.item_id'); // ensure match on item
            })
            ->where('vl.vendor_id', $vendorId)
            ->select(
                'vl.id as ledger_id',
                'vl.received_date',
                'vl.quantity as ledger_quantity',
                'vl.amount as ledger_amount',
                'o.id as order_id',
                'o.order_name',
                'o.item_name',
                'voa.item_id as assigned_item_index'
            )
            ->orderBy('vl.received_date', 'desc')
            ->get();

        $detailedEntries = [];
        $totalQuantity = 0;
        $totalAmount = 0;

        foreach ($ledgerEntries as $entry) {
            $itemNames = json_decode($entry->item_name, true);

            // Convert 1-based item_id to 0-based index
            $zeroBasedIndex = $entry->assigned_item_index - 1;
            $assignedItemName = $itemNames[$zeroBasedIndex] ?? 'Unknown';

            $detailedEntries[] = [
                'ledger_id'     => $entry->ledger_id,
                'received_date' => $entry->received_date,
                'order_id'      => $entry->order_id,
                'order_name'    => $entry->order_name,
                'item_name'     => $assignedItemName,
                'quantity'      => $entry->ledger_quantity,
                'amount'        => $entry->ledger_amount,
            ];

            $totalQuantity += $entry->ledger_quantity;
            $totalAmount += $entry->ledger_amount ?? 0;
        }

        $summary = [
            'total_quantity' => $totalQuantity,
            'total_amount'   => $totalAmount,
        ];

        return response()->json([
            'vendor'        => $vendor,
            'ledgerEntries' => $detailedEntries,
            'summary'       => $summary,
        ]);
    }

    public function Estimated_report()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            return view('admin_panel.reporting.Estimated-report', []);
        } else {
            return redirect()->back();
        }
    }

    public function filter_Estimated_report(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $estimates = DB::table('menu_estimates')
            ->whereBetween('sale_date', [$start, $end])
            ->get();

        $total = $estimates->count();
        $confirmed = $estimates->where('status', 1)->count();
        $pending = $estimates->where('status', null)->count();
        $totalAmount = $estimates->sum('total_price');

        return response()->json([
            'total_estimates' => $total,
            'confirmed_estimates' => $confirmed,
            'pending_estimates' => $pending,
            'total_amount' => $totalAmount,
            'estimates' => $estimates
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AccountantLedger;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{

    public function welcome(Request $request)
    {
        $products = Product::all(); // Sare products le ayega

        $all_categories = Category::get()
            ->map(function ($category) {
                $category->products_count = $category->products()->count();
                return $category;
            });
        return view('welcome', compact('products', 'all_categories'));
    }

    public function home()
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;

            if ($usertype == 'staff') {

                // Fetch all categories for the dropdown
                $categories = Category::all();

                // Initially, load all products for display (optional, can be removed if you prefer to only load products on category change)
                $products = Product::all();
                $Customers = Customer::all();
                $Warehouses = Warehouse::get();


                return view('user_panel.user_dashboard', compact('categories', 'products', 'Customers', 'Warehouses'));
            } else if ($usertype == 'super admin') {
                $userId = Auth::id();
                $totalPurchasesPrice = \App\Models\Purchase::sum('total_price');
                $totalPurchaseReturnsPrice = \App\Models\PurchaseReturn::sum('total_price');
                // Fetch all products for the logged-in admin
                // $all_product = Product::where('admin_or_user_id', '=', $userId)->get();
                $all_product = Product::get();

                // Calculate total stock value for all products
                $totalStockValue = $all_product->sum(function ($product) {
                    return $product->stock * $product->wholesale_price;
                });


                // Calculate total stock value for each product
                foreach ($all_product as $product) {
                    $product->total_stock_value = $product->stock * $product->wholesale_price;
                }


                $categories = DB::table('categories')->count();
                $subcategories = DB::table('subcategories')->count();
                $products = DB::table('products')->count();
                $suppliers = DB::table('suppliers')->count();
                $customers = DB::table('customers')->count();
                $totalsales = DB::table('sales')->sum('Payable_amount');

                // $lowStockProducts = Product::whereRaw('CAST(stock AS UNSIGNED) <= CAST(alert_quantity AS UNSIGNED)')->get();
                // dd($lowStockProducts);
                return view('Super_admin.superadmin_dashboard', compact('totalPurchasesPrice', 'subcategories', 'totalPurchaseReturnsPrice', 'all_product', 'totalStockValue', 'categories', 'products', 'suppliers', 'customers', 'totalsales'));
            } else if ($usertype == 'admin') {
                $userId = Auth::id();

                // Orders table calculations
                $totalOrderAmount = DB::table('orders')->sum('payable_amount');
                $paidAmount = DB::table('orders')->sum('advance_paid');
                $remainingAmount = DB::table('orders')->sum('remaining_amount');

                // Menu Estimates table calculation
                $pendingEstimated = DB::table('menu_estimates')->sum('total_price');

                $Categories = DB::table('item_categories')->count();
                $Brands = DB::table('brands')->count();
                $Products = DB::table('item_products')->count();

                $TotalPurchaseAmount = DB::table('purchases')->sum('Payable_amount');
                $TotalPurchaseReturn  = DB::table('purchase_returns')->sum('payable_amount');
                $TotalClaimReturn = DB::table('claim_returns')->sum('payable_amount');

                
                $deliveredOrders = DB::table('orders')->where('order_status', 'Delivered')->count();
                $pendingOrders = DB::table('orders')->where('order_status', 'Pending')->count();
                $confirmedOrders = DB::table('orders')->where('order_status', 'confirmed')->count();
                $preparingOrders = DB::table('orders')->where('order_status', 'Preparing')->count();
                $cancelledOrders = DB::table('orders')->where('order_status', 'Cancelled')->count();

                $totalEstimates = DB::table('menu_estimates')->count();

                $statuses = ['Delivered', 'Pending', 'confirmed', 'Preparing', 'Cancelled'];

                // ===== ORDER STATUS CHARTS =====
                // DAILY
                $dailyLabels = collect(range(6, 0))->map(fn($i) => Carbon::today()->subDays($i)->format('Y-m-d'));
                $dailySeries = [];
                foreach ($statuses as $status) {
                    $data = $dailyLabels->map(function ($date) use ($status) {
                        return DB::table('orders')
                            ->whereDate('created_at', $date)
                            ->where('order_status', $status)
                            ->count();
                    });
                    $dailySeries[] = ['name' => $status, 'data' => $data];
                }

                // WEEKLY
                $weeklyLabels = ['This Week', 'Last Week', '2 Weeks Ago'];
                $weeklySeries = [];
                foreach ($statuses as $status) {
                    $data = collect([0, 1, 2])->map(function ($i) use ($status) {
                        $start = Carbon::now()->startOfWeek()->subWeeks($i);
                        $end = $start->copy()->endOfWeek();
                        return DB::table('orders')
                            ->whereBetween('created_at', [$start, $end])
                            ->where('order_status', $status)
                            ->count();
                    });
                    $weeklySeries[] = ['name' => $status, 'data' => $data->reverse()->values()];
                }

                // MONTHLY
                $months = range(1, Carbon::now()->month);
                $monthLabels = collect($months)->map(fn($m) => Carbon::create()->month($m)->format('F'));
                $monthlySeries = [];
                foreach ($statuses as $status) {
                    $data = collect($months)->map(function ($month) use ($status) {
                        return DB::table('orders')
                            ->whereMonth('created_at', $month)
                            ->whereYear('created_at', Carbon::now()->year)
                            ->where('order_status', $status)
                            ->count();
                    });
                    $monthlySeries[] = ['name' => $status, 'data' => $data];
                }

                $orderChartStats = [
                    'daily' => [
                        'categories' => $dailyLabels,
                        'series' => $dailySeries
                    ],
                    'weekly' => [
                        'categories' => $weeklyLabels,
                        'series' => $weeklySeries
                    ],
                    'monthly' => [
                        'categories' => $monthLabels,
                        'series' => $monthlySeries
                    ]
                ];

                // ===== ORDER PAYMENT CHARTS =====
                $paymentFields = [
                    'Advance Paid' => 'advance_paid',
                    'Remaining' => 'remaining_amount',
                    'Discount' => 'discount',
                    'Payable Amount' => 'payable_amount',
                    'Total Amount' => 'payable_amount'
                ];

                // DAILY PAYMENT
                $dailyPaymentLabels = $dailyLabels;
                $dailyPaymentSeries = [];
                foreach ($paymentFields as $label => $field) {
                    $data = $dailyPaymentLabels->map(function ($date) use ($field) {
                        return DB::table('orders')
                            ->whereDate('created_at', $date)
                            ->sum($field);
                    });
                    $dailyPaymentSeries[] = ['name' => $label, 'data' => $data];
                }

                // WEEKLY PAYMENT
                $weeklyPaymentSeries = [];
                foreach ($paymentFields as $label => $field) {
                    $data = collect([0, 1, 2])->map(function ($i) use ($field) {
                        $start = Carbon::now()->startOfWeek()->subWeeks($i);
                        $end = $start->copy()->endOfWeek();
                        return DB::table('orders')
                            ->whereBetween('created_at', [$start, $end])
                            ->sum($field);
                    });
                    $weeklyPaymentSeries[] = ['name' => $label, 'data' => $data->reverse()->values()];
                }

                // MONTHLY PAYMENT
                $monthlyPaymentSeries = [];
                foreach ($paymentFields as $label => $field) {
                    $data = collect($months)->map(function ($month) use ($field) {
                        return DB::table('orders')
                            ->whereMonth('created_at', $month)
                            ->whereYear('created_at', Carbon::now()->year)
                            ->sum($field);
                    });
                    $monthlyPaymentSeries[] = ['name' => $label, 'data' => $data];
                }

                $paymentChartStats = [
                    'daily' => [
                        'categories' => $dailyPaymentLabels,
                        'series' => $dailyPaymentSeries
                    ],
                    'weekly' => [
                        'categories' => $weeklyLabels,
                        'series' => $weeklyPaymentSeries
                    ],
                    'monthly' => [
                        'categories' => $monthLabels,
                        'series' => $monthlyPaymentSeries
                    ]
                ];

                return view('admin_panel.admin_dashboard', compact(
                    'totalOrderAmount',
                    'paidAmount',
                    'remainingAmount',
                    'pendingEstimated',
                    'deliveredOrders',
                    'pendingOrders',
                    'confirmedOrders',
                    'preparingOrders',
                    'cancelledOrders',
                    'totalEstimates',
                    'orderChartStats',
                    'paymentChartStats',// ✅ Pass this to Blade
                    'Categories',
                    'Brands',
                    'Products',
                    'TotalPurchaseAmount',
                    'TotalPurchaseReturn',
                    'TotalClaimReturn',
                ));
            }

            if ($usertype == 'Accountant') {
                // Fetch all categories for the dropdown
                $accountant = Auth::user();

                $ledger = AccountantLedger::where('accountant_id', $accountant->user_id)->latest()->first();

                $cashInHand = $ledger ? $ledger->cash_in_hand : 0;
                return view('Accountant_panel.accountant_dashboard', compact('cashInHand'));
            }
        } else {
            return Redirect()->route('login');
        }
    }

    public function adminpage()
    {
        return view('admin_panel.admin_page');
    }

    public function dashboard()
    {
        return view('admin_panel.dashboard');
    }

    public function Admin_Change_Password()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            return view('admin_panel.change_password', []);
        } else {
            return redirect()->back();
        }
    }

    public function updte_change_Password(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->withErrors(['error' => 'User not authenticated']);
        }

        // Validate input
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'retype_new_password' => 'required|same:new_password',
        ]);

        $user = Auth::user();

        // Ensure only admin can change password
        if ($user->usertype !== 'admin') {
            return redirect()->back()->withErrors(['error' => 'Unauthorized action']);
        }

        // Verify old password
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Old password is incorrect']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Flash success message
        return redirect()->back()->with('success', 'Password changed successfully');
    }


    // Staff work 

    public function getProductsByCategory(Request $request)
    {
        $categoryname = $request->categoryname;
        // dd($categoryname);
        // Fetch products based on the selected category
        $products = Product::where('category', $categoryname)->get();
        // dd($products);
        // Return JSON response
        return response()->json($products);
    }

    public function getProductByBarcode(Request $request)
    {
        $barcode = $request->query('barcode'); // Get barcode from query parameters
        $product = Product::where('barcode_number', $barcode)->first();

        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(null, 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ItemCategory;
use App\Models\ItemProduct;
use App\Models\Product;
use App\Models\StockTransfer;
use App\Models\Warehouse;
use App\Models\WarehouseProductStock;
use App\Models\WarehouseStock;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class warehouseStockController extends Controller
{
    public function warehouse_stock()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            $Warehouses = Warehouse::get();
            $Category = ItemCategory::get();
            // dd($Purchases);
            return view('admin_panel.warehousestock.add_warehouse_stock', [
                'Warehouses' => $Warehouses,
                'Category' => $Category,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function store_warehouse_stock(Request $request)
    {
        $request->validate([
            'stock_date' => 'required|date',
            'warehouse_id' => 'required',
            'supplier_name' => 'required',
            'item_category' => 'required|array',
            'item_name' => 'required|array',
            'brand' => 'required|array',
            'quantity' => 'required|array',
        ]);

        $warehouseName = $request->warehouse_id; // ID nahi, name store ho raha hai
        $supplier_name = $request->supplier_name; // ID nahi, name store ho raha hai
        $userId = Auth::id();

        foreach ($request->item_name as $index => $productName) {
            $category = $request->item_category[$index];
            $model = $request->brand[$index];
            $quantity = (int) $request->quantity[$index];

            // Insert new stock entry
            WarehouseStock::create([
                'admin_or_user_id'    => $userId,
                'stock_date' => $request->stock_date,
                'warehouse_name' => $warehouseName,
                'supplier_name' => $supplier_name,
                'category' => $category,
                'product_name' => $productName,
                'model' => $model,
                'quantity' => $quantity,
            ]);

            // Update warehouse_product_stock
            $existingStock = WarehouseProductStock::where([
                'warehouse_name' => $warehouseName,
                'category' => $category,
                'product_name' => $productName,
            ])->first();

            if ($existingStock) {
                // Agar record exist karta hai to quantity update karein
                $existingStock->increment('quantity', $quantity);
            } else {
                // Naya record create karein agar nahi hai
                WarehouseProductStock::create([
                    'warehouse_name' => $warehouseName,
                    'category' => $category,
                    'product_name' => $productName,
                    'brand' => $model,
                    'quantity' => $quantity,
                ]);
            }
        }

        return back()->with('success', 'Warehouse stock added successfully!');
    }


    public function listing_warehouse_stock()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            $WarehouseStocks = WarehouseStock::where('admin_or_user_id', '=', $userId)->get();
            return view('admin_panel.warehousestock.listing_warehouse_stock', [
                'WarehouseStocks' => $WarehouseStocks
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function product_warehouse_stock()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // dd($userId);
            $Warehouses = Warehouse::get();
            $Categories = ItemCategory::get();
            // dd($Purchases);
            return view('admin_panel.warehousestock.product_warehouse_stock', [
                'Warehouses' => $Warehouses,
                'Categories' => $Categories,
            ]);
        } else {
            return redirect()->back();
        }
    }


    public function getProductsByCategory(Request $request)
    {
        $categoryName = $request->input('categoryName');

        // Fetch products with their name and brand
        $products = ItemProduct::where('category', $categoryName)
            ->select('id', 'product_name', 'brand')
            ->get();

        return response()->json($products);
    }


    public function filterWarehouseStock(Request $request)
    {
        $warehouseName = $request->input('warehouse_name');
        $category = $request->input('category');
        $productName = $request->input('product_name');

        $query = WarehouseProductStock::query();

        if ($warehouseName) {
            $query->where('warehouse_name', $warehouseName);
        }
        if ($category) {
            $query->where('category', $category);
        }
        if ($productName) {
            $query->where('product_name', $productName);
        }

        $stocks = $query->get();

        return response()->json($stocks);
    }

    public function warehouse_to_shop_stock(Request $request)
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $Warehouses = Warehouse::get();
            $Categories = ItemCategory::get();
            // $Products = Product::with('warehouseStock')->get();
            // dd($Products); // Debugging ke liye
            return view('admin_panel.warehousestock.warehouse_to_shop_stock', [
                'Warehouses' => $Warehouses,
                'Categories' => $Categories
                // 'Products' => $Products
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function getStock(Request $request)
    {
        $warehouseName = $request->warehouse;
        $categoryName = $request->category;
        $productName = $request->product;

        $stock = WarehouseProductStock::where('warehouse_name', $warehouseName)
            ->where('category', $categoryName)
            ->where('product_name', $productName)
            ->pluck('quantity')
            ->first(); // Stock ki quantity extract karna

        return response()->json(['stock' => $stock ?? 0]); // Agar stock null ho to 0 return karein
    }

    public function store_warehouse_to_shop(Request $request)
    {
        DB::beginTransaction();
        try {
            // Warehouse Stock Fetch
            $warehouseStock = WarehouseProductStock::where([
                'warehouse_name' => $request->warehouse_name,
                'product_name' => $request->product_name,
            ])->first();

            if (!$warehouseStock || $warehouseStock->quantity < $request->quantity) {
                return back()->with('error', 'Insufficient stock in warehouse.');
            }

            // Manual Update Instead of decrement()
            $warehouseStock->quantity -= $request->quantity;
            $warehouseStock->save();

            // Update Product Stock
            $product = ItemProduct::where('product_name', $request->product_name)->first();
            if (!$product) {
                return back()->with('error', 'Product not found.');
            }
            $product->increment('stock', $request->quantity);

            // Save Stock Transfer Record
            StockTransfer::create([
                'warehouse_name' => $request->warehouse_name,
                'category' => $request->category,
                'product_name' => $request->product_name,
                'quantity' => $request->quantity,
                'transfer_date' => $request->transfer_date,
            ]);

            DB::commit();
            return back()->with('success', 'Stock transferred successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function All_Stock_Transfer(Request $request)
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $Warehouses = Warehouse::all();
            $Categories = ItemCategory::all();
            $StockTransfers = StockTransfer::latest()->get(); // Get all stock transfers

            return view('admin_panel.warehousestock.All_Stock_Transfer', [
                'Warehouses' => $Warehouses,
                'Categories' => $Categories,
                'StockTransfers' => $StockTransfers
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function getitemsbycategoryproduct($categoryId)
    {
        $items = ItemProduct::where('category', $categoryId)->get(); // Adjust according to your database structure
        return response()->json($items);
    }


    public function getunitbyitemproduct($productId)
    {
        $product = ItemProduct::where('product_name', $productId)->first();
        return response()->json([
            'brand' => $product->brand,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\ItemCategory;
use App\Models\ItemProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemProductController extends Controller
{
    
    public function all_item_product()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // $all_unit = Unit::where('admin_or_user_id', '=', $userId)->get();
            $all_product = ItemProduct::get();
            return view('admin_panel.item_products.all_product', [
                // 'all_unit' => $all_unit
                'all_product' => $all_product,
            ]);
        } else {
            return redirect()->back();
        }
    }
    public function add_item_product()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $all_category = ItemCategory::where('admin_or_user_id', '=', $userId)->get();
            $all_brand = Brand::where('admin_or_user_id', '=', $userId)->get();

            return view('admin_panel.item_products.add_product', [
                'all_category' => $all_category,
                'all_brand' => $all_brand,
            ]);
        } else {
            return redirect()->back();
        }
    }

    
    public function getItems($category, $subcategory)
    {
        $items = ItemCategory::where('category_id', $category)
            ->where('subcategory_id', $subcategory)
            ->with('unit:id,unit') // Yeh ensure karega ke sirf unit ka name aaye
            ->get(['id', 'name', 'unit_id', 'price']);

        // Data modify karke response bhejna
        $items = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'unit' => $item->unit ? $item->unit->unit : '', // Agar unit available hai toh name le lo
                'price' => $item->price,
            ];
        });

        return response()->json($items);
    }



    public function store_item_product(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();


            // Create the product with or without the image
            ItemProduct::create([
                'admin_or_user_id' => $userId,
                'product_name'     => $request->product_name,
                'category'         => $request->category,
                'brand'            => $request->brand,
                'stock'            => $request->stock,
                'retail_price'            => $request->retail_price,
                'alert_quantity'   => $request->alert_quantity,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ]);

            return redirect()->back()->with('success', 'Product Added Successfully');
        } else {
            return redirect()->back();
        }
    }

    public function edit_item_product($id)
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $all_category = ItemCategory::where('admin_or_user_id', '=', $userId)->get();
            $all_brand = Brand::where('admin_or_user_id', '=', $userId)->get();
            $product_details = ItemProduct::findOrFail($id);
            // dd($product_details);
            return view('admin_panel.item_products.edit_product', [
                'all_category' => $all_category,
                'all_brand' => $all_brand,
                'product_details' => $product_details,

            ]);
        } else {
            return redirect()->back();
        }
    }

    public function update_item_product(Request $request, $id)
    {
        if (Auth::id()) {
            $userId = Auth::id();

            // Find the product by ID
            $product = ItemProduct::findOrFail($id);

            // Handle image upload if a new image is provided
            if ($request->hasFile('image')) {
                // Delete the old image if exists
                if ($product->image) {
                    $oldImagePath = public_path('product_images/' . $product->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Upload new image
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('product_images'), $imageName);

                // Set the new image name in the product data
                $product->image = $imageName;
            }

            // Update product details
            $product->product_name   = $request->product_name;
            $product->category       = $request->category;
            $product->brand          = $request->brand;
            $product->sku            = $request->sku;
            $product->unit           = $request->unit;
            $product->alert_quantity = $request->alert_quantity;
            $product->retail_price   = $request->retail_price;  // Including retail price update
            $product->note           = $request->note;
            $product->updated_at     = Carbon::now();

            // Save updated product
            $product->save();

            return redirect()->route('all-product')->with('success', 'Product updated successfully');
        } else {
            return redirect()->back();
        }
    }

    public function getProductDetails($productName)
    {
        $product = ItemProduct::where('product_name', $productName)->first();
        if ($product) {
            return response()->json([
                'retail_price' => $product->retail_price,
                'stock' => $product->stock,
            ]);
        }
        return response()->json(['message' => 'Product not found'], 404);
    }

    public function searchProducts(Request $request)
    {
        $query = $request->get('q');

        // Perform a search based on the product name
        $products = ItemProduct::where('product_name', 'like', '%' . $query . '%')
            ->get(['id', 'category', 'product_name', 'retail_price']);

        return response()->json($products);
    }

    public function item_product_alerts()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $lowStockProducts = ItemProduct::whereRaw('CAST(stock AS UNSIGNED) <= CAST(alert_quantity AS UNSIGNED)')->get();
            // dd($lowStockProducts);
            return view('admin_panel.item_products.product_alerts', [
                'lowStockProducts' => $lowStockProducts,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function delete_item_product(Request $request)
    {
        if (Auth::id()) {
            $product = ItemProduct::find($request->id);

            if ($product) {
                $product->delete();
                return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Product not found.']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Unauthorized request.']);
    }
}

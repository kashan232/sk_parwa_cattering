<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function all_product()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            // $all_unit = Unit::where('admin_or_user_id', '=', $userId)->get();
            $all_product = Product::get();
            return view('admin_panel.product.all_product', [
                // 'all_unit' => $all_unit
                'all_product' => $all_product,
            ]);
        } else {
            return redirect()->back();
        }
    }
    public function add_product()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $all_category = Category::where('admin_or_user_id', '=', $userId)->get();
            $all_brand = Brand::where('admin_or_user_id', '=', $userId)->get();
            $all_unit = Unit::where('admin_or_user_id', '=', $userId)->get();

            return view('admin_panel.product.add_product', [
                'all_category' => $all_category,
                'all_brand' => $all_brand,
                'all_unit' => $all_unit,

            ]);
        } else {
            return redirect()->back();
        }
    }

    public function getSubcategories($category)
    {
        $subcategories = SubCategory::where('category_id', $category)->first();
        // dd($subcategories);

        return response()->json($subcategories); // Return JSON response
    }
    
    public function store_product(Request $request)
    {
        // dd($request->toArray());
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();

            // Handle image upload if the image is provided
            $imageName = null;  // Default to null if no image is uploaded
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'product_images/' . $imageName;

                // Save the original image to the public directory
                $image->move(public_path('product_images'), $imageName);
            }

            // Create the product with or without the image
            Product::create([
                'name'     => $request->product_name,
                'category_id'         => $request->category,
                'subcategory_id'         => $request->sub_category,
                'unit_id'         => $request->unit,
                'price'            => $request->price,
                'image'            => $imageName,
            ]);

            return redirect()->back()->with('success', 'Product Added Successfully');
        } else {
            return redirect()->back();
        }
    }
    public function edit_product($id)
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $all_category = Category::where('admin_or_user_id', '=', $userId)->get();
            $all_brand = Brand::where('admin_or_user_id', '=', $userId)->get();
            $all_unit = Unit::where('admin_or_user_id', '=', $userId)->get();
            $product_details = Product::findOrFail($id);
            // dd($product_details);
            return view('admin_panel.product.edit_product', [
                'all_category' => $all_category,
                'all_brand' => $all_brand,
                'all_unit' => $all_unit,
                'product_details' => $product_details,

            ]);
        } else {
            return redirect()->back();
        }
    }

    public function update_product(Request $request, $id)
    {
        if (Auth::id()) {
            $userId = Auth::id();

            // Find the product by ID
            $product = Product::findOrFail($id);

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
        $product = Product::where('product_name', $productName)->first();
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
        $products = Product::where('product_name', 'like', '%' . $query . '%')
            ->get(['id', 'category', 'product_name', 'retail_price']);

        return response()->json($products);
    }

    public function product_alerts()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $lowStockProducts = Product::whereRaw('CAST(stock AS UNSIGNED) <= CAST(alert_quantity AS UNSIGNED)')->get();
            // dd($lowStockProducts);
            return view('admin_panel.product.product_alerts', [
                'lowStockProducts' => $lowStockProducts,
            ]);
        } else {
            return redirect()->back();
        }
    }
}

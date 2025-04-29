<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemCategoryController extends Controller
{
    
    public function item_category()
    {
        if (Auth::id()) {
            $userId = Auth::id();
            $all_categories = ItemCategory::get();
                
    
            return view('admin_panel.item_category.item_category', [
                'all_categories' => $all_categories
            ]);
        } else {
            return redirect()->back();
        }
    }
    public function item_store_category(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            ItemCategory::create([
                'admin_or_user_id'    => $userId,
                'category'          => $request->category,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'Category Added Successfully');
        } else {
            return redirect()->back();
        }
    }
    public function item_update_category(Request $request)
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            $userId = Auth::id();
            // dd($reques   t);
            $update_id = $request->input('category_id');
            $category = $request->input('category_name');

            ItemCategory::where('id', $update_id)->update([
                'category'   => $category,
                'updated_at' => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'Category Updated Successfully');
        } else {
            return redirect()->back();
        }
    }

}

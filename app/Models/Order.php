<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function vendorOrderAssigns()
    {
        return $this->hasMany(VendorOrderAssign::class, 'order_id');
    }

    public function subcategories()
    {
        $categoryIds = json_decode($this->item_subcategory, true);

        return Subcategory::whereIn('id', $categoryIds)->get();
    }
}

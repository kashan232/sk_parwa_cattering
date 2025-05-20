<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorOrderAssign extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }
}

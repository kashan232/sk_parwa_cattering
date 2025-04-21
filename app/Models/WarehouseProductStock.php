<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseProductStock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function warehouseStock()
    {
        return $this->hasMany(WarehouseProductStock::class, 'product_id', 'id');
    }
}

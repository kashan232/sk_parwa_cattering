<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuEstimate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];


     public function subcategories()
    {
        $categoryIds = json_decode($this->item_subcategory, true);

        return Subcategory::whereIn('id', $categoryIds)->get();
    }

}

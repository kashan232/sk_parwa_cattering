<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GatePass extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];


    public function items()
    {
        return $this->hasMany(GatePassItem::class, 'gate_pass_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accountant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function ledger()
    {
        return $this->hasOne(AccountantLedger::class, 'accountant_id', 'id');
    }

    public function expenses()
    {
        return $this->hasMany(AccountantExpense::class, 'accountant_id');
    }
}

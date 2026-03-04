<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tenant()
    {
        return $this->belongsTo(\App\Models\Tenant::class);
    }
    // 1. 顧客とのリレーション
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

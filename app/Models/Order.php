<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    /**
     * Incrementing sequence per tenant: 01–99 zero-padded, then 100, 101, …
     */
    public static function formatOrderNumberFromSequence(int $sequence): string
    {
        if ($sequence < 1) {
            return '01';
        }
        if ($sequence < 100) {
            return str_pad((string) $sequence, 2, '0', STR_PAD_LEFT);
        }

        return (string) $sequence;
    }

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

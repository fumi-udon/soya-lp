<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];
    protected $casts = ['variants' => 'array'];

    public function tenant()
    {
        return $this->belongsTo(\App\Models\Tenant::class);
    }
}

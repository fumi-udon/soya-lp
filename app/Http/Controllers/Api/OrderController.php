<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'order_type' => 'required|string',
            'notes' => 'nullable|string',
            'total_price' => 'required|numeric',
            'items' => 'required|array',
        ]);

        // 1. アクセスされたドメインから店舗(Tenant)を特定
        $host = $request->getHost();
        if (in_array($host, ['localhost', '127.0.0.1'])) {
            $host = 'soya.bistronippon.tn';
        }
        $tenant = Tenant::where('domain', $host)->firstOrFail();

        $order = DB::transaction(function () use ($validated, $tenant) {
            $orderNumber = strtoupper(Str::random(4));

            $order = Order::create([
                'tenant_id' => $tenant->id, // ★店舗IDを保存
                'order_number' => $orderNumber,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'order_type' => $validated['order_type'],
                'notes' => $validated['notes'],
                'total_price' => $validated['total_price'],
            ]);

            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'tenant_id' => $tenant->id, // ★店舗IDを保存
                    'order_id' => $order->id,
                    'product_id' => $item['productId'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'variants' => $item['variants'],
                ]);
            }
            return $order;
        });

        return response()->json(['success' => true, 'order_number' => $order->order_number]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'order_type' => 'required|string',
            'notes' => 'nullable|string',
            'total_price' => 'required|numeric',
            'items' => 'required|array',
        ]);

        $order = DB::transaction(function () use ($validated) {
            // ランダムな4桁の英数字を発行（例: 8F2A）
            $orderNumber = strtoupper(Str::random(4));

            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'order_type' => $validated['order_type'],
                'notes' => $validated['notes'],
                'total_price' => $validated['total_price'],
            ]);

            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['productId'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'variants' => $item['variants'],
                ]);
            }
            return $order;
        });

        // 生成したオーダー番号をフロントエンドに返す
        return response()->json(['success' => true, 'order_number' => $order->order_number]);
    }
}

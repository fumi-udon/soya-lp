<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tenant;
use App\Models\Customer; // ★追加
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

        $host = $request->getHost();
        if (in_array($host, ['localhost', '127.0.0.1'])) {
            $host = 'soya.bistronippon.tn';
        }
        $tenant = Tenant::where('domain', $host)->firstOrFail();

        $order = DB::transaction(function () use ($validated, $tenant) {

            // ★1. 顧客データの取得または新規作成（電話番号をキーにする）
            $customer = Customer::firstOrCreate(
                ['phone' => $validated['customer_phone']],
                ['name' => $validated['customer_name']]
            );

            $orderNumber = strtoupper(Str::random(4));

            // ★2. 注文データの作成（customer_idを追加）
            // テスト注文判定（小文字変換してチェック）
            $testNames = ['test', 'テスト', 'てすと'];
            $isTest = in_array(mb_strtolower($validated['customer_name']), $testNames, true);

            $order = Order::create([
                'tenant_id' => $tenant->id,
                'customer_id' => $customer->id,
                'order_number' => $orderNumber,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'order_type' => $validated['order_type'],
                'notes' => $validated['notes'],
                'total_price' => $validated['total_price'],
                'is_test' => $isTest, // ★追加
            ]);

            // 3. 注文明細データの作成
            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'tenant_id' => $tenant->id,
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewOrderNotification;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tenant;
use App\Support\OrderWhatsAppUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

            $customer = Customer::firstOrCreate(
                ['phone' => $validated['customer_phone']],
                ['name' => $validated['customer_name']]
            );

            $orderNumber = strtoupper(Str::random(4));

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
                'is_test' => $isTest,
            ]);

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

        $order->load('items');

        $recipient = $tenant->order_notification_email ?: config('mail.order_notification.address');
        $recipient = $recipient ? trim((string) $recipient) : null;

        if ($recipient && filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($recipient)->send(new NewOrderNotification($order, $tenant));
            } catch (\Throwable $e) {
                Log::error('order_notification_mail_failed', [
                    'tenant_id' => $tenant->id,
                    'order_id' => $order->id,
                    'message' => $e->getMessage(),
                ]);
            }
        } else {
            Log::warning('order_notification_no_valid_recipient', [
                'tenant_id' => $tenant->id,
                'recipient' => $recipient,
            ]);
        }

        $whatsappUrl = OrderWhatsAppUrl::build($order, $tenant);

        return response()->json([
            'success' => true,
            'order_number' => $order->order_number,
            'whatsapp_url' => $whatsappUrl,
        ]);
    }
}

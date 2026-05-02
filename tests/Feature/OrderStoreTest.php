<?php

namespace Tests\Feature;

use App\Mail\NewOrderNotification;
use App\Models\Tenant;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Uses SQLite :memory: so MySQL/Sail is not required. Install php-sqlite3 / pdo_sqlite to run.
 */
class OrderStoreTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('pdo_sqlite is required for OrderStoreTest (in-memory DB).');
        }

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'mail.order_notification.send_enabled' => true,
        ]);
        $this->app['db']->purge();

        $this->artisan('migrate:fresh', ['--force' => true]);
    }

    protected function createTenant(array $overrides = []): Tenant
    {
        return Tenant::create(array_merge([
            'name' => 'Test Bistro',
            'domain' => 'soya.bistronippon.tn',
            'theme_primary' => '#e60012',
            'theme_bg' => '#eaedf0',
            'whatsapp_number' => '216555555555',
        ], $overrides));
    }

    public function test_order_store_sends_mail_and_returns_whatsapp_url(): void
    {
        Mail::fake();

        config(['mail.order_notification.address' => 'kitchen@example.test']);

        $this->createTenant();

        $payload = [
            'customer_name' => 'Jane',
            'customer_phone' => '+216111111',
            'order_type' => 'Takeaway',
            'notes' => 'No onions',
            'total_price' => 15.5,
            'items' => [
                [
                    'productId' => null,
                    'name' => 'Curry Set (Spicy)',
                    'price' => 15.5,
                    'variants' => [
                        ['id' => 1, 'name' => 'Extra rice', 'price_adjustment' => 0],
                    ],
                ],
            ],
        ];

        $response = $this->postJson('http://soya.bistronippon.tn/api/orders', $payload, [
            'Accept' => 'application/json',
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('order_number', '01')
            ->assertJsonStructure(['order_number', 'whatsapp_url']);

        $url = $response->json('whatsapp_url');
        $this->assertIsString($url);
        $this->assertStringStartsWith('https://api.whatsapp.com/send/', $url);
        $this->assertStringContainsString('phone=216555555555', $url);

        Mail::assertSent(NewOrderNotification::class, function (NewOrderNotification $mail) {
            return $mail->hasTo('kitchen@example.test')
                && str_contains($mail->subject, 'Test Bistro')
                && str_contains($mail->subject, 'New order #');
        });
    }

    public function test_order_notification_uses_tenant_email_when_set(): void
    {
        Mail::fake();

        config(['mail.order_notification.address' => 'fallback@example.test']);

        $this->createTenant([
            'order_notification_email' => 'custom@example.test',
        ]);

        $payload = [
            'customer_name' => 'Bob',
            'customer_phone' => '+216222222',
            'order_type' => 'Takeaway',
            'notes' => null,
            'total_price' => 10,
            'items' => [
                [
                    'productId' => null,
                    'name' => 'Soup',
                    'price' => 10,
                    'variants' => [],
                ],
            ],
        ];

        $this->postJson('http://soya.bistronippon.tn/api/orders', $payload, [
            'Accept' => 'application/json',
        ])->assertOk();

        Mail::assertSent(NewOrderNotification::class, fn (NewOrderNotification $mail) => $mail->hasTo('custom@example.test'));
        Mail::assertNotSent(NewOrderNotification::class, fn (NewOrderNotification $mail) => $mail->hasTo('fallback@example.test'));
    }

    public function test_order_mail_includes_staff_name_from_product(): void
    {
        Mail::fake();

        config(['mail.order_notification.address' => 'kitchen@example.test']);

        $tenant = $this->createTenant();

        $category = \App\Models\Category::create([
            'tenant_id' => $tenant->id,
            'name' => 'Mains',
            'slug' => 'mains-'.uniqid(),
            'is_active' => true,
            'sort_order' => 0,
        ]);

        $product = \App\Models\Product::create([
            'tenant_id' => $tenant->id,
            'category_id' => $category->id,
            'name' => 'Public Ramen',
            'staff_name' => 'RAMEN-A',
            'slug' => 'ramen-'.uniqid(),
            'price' => 12,
            'is_active' => true,
            'order_type' => 'kitchen',
            'sort_order' => 0,
        ]);

        $payload = [
            'customer_name' => 'ChefTest',
            'customer_phone' => '+216333333',
            'order_type' => 'Takeaway',
            'notes' => null,
            'total_price' => 12,
            'items' => [
                [
                    'productId' => $product->id,
                    'name' => 'Public Ramen (Large)',
                    'price' => 12,
                    'variants' => [],
                ],
            ],
        ];

        $this->postJson('http://soya.bistronippon.tn/api/orders', $payload, [
            'Accept' => 'application/json',
        ])->assertOk();

        Mail::assertSent(NewOrderNotification::class, function (NewOrderNotification $mail) {
            $html = $mail->render();

            return str_contains($html, 'Public Ramen (Large)')
                && str_contains($html, 'RAMEN-A');
        });
    }

    public function test_takeout_mail_send_false_skips_email(): void
    {
        Mail::fake();

        config([
            'mail.order_notification.address' => 'kitchen@example.test',
            'mail.order_notification.send_enabled' => false,
        ]);

        $this->createTenant();

        $payload = [
            'customer_name' => 'NoMail',
            'customer_phone' => '+216444444',
            'order_type' => 'Takeaway',
            'notes' => null,
            'total_price' => 5,
            'items' => [
                [
                    'productId' => null,
                    'name' => 'Item',
                    'price' => 5,
                    'variants' => [],
                ],
            ],
        ];

        $this->postJson('http://soya.bistronippon.tn/api/orders', $payload, [
            'Accept' => 'application/json',
        ])->assertOk()->assertJsonPath('success', true);

        Mail::assertNothingSent();
    }

    public function test_order_number_increments_per_tenant(): void
    {
        Mail::fake();

        config(['mail.order_notification.address' => 'kitchen@example.test']);

        $this->createTenant();

        $payload = [
            'customer_name' => 'First',
            'customer_phone' => '+216500001',
            'order_type' => 'Takeaway',
            'notes' => null,
            'total_price' => 1,
            'items' => [
                [
                    'productId' => null,
                    'name' => 'A',
                    'price' => 1,
                    'variants' => [],
                ],
            ],
        ];

        $this->postJson('http://soya.bistronippon.tn/api/orders', $payload, [
            'Accept' => 'application/json',
        ])->assertOk()->assertJsonPath('order_number', '01');

        $payload['customer_name'] = 'Second';
        $payload['customer_phone'] = '+216500002';

        $this->postJson('http://soya.bistronippon.tn/api/orders', $payload, [
            'Accept' => 'application/json',
        ])->assertOk()->assertJsonPath('order_number', '02');
    }
}

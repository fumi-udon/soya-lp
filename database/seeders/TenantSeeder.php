<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run()
    {
        $tenants = [
            [
                'name' => 'Söya',
                // 本番環境のSöya用ドメイン（またはローカルテスト用）
                'domain' => 'soya.bistronippon.tn',
                'theme_primary' => '#e60012', // キッコーマンレッド
                'theme_bg' => '#eaedf0',      // コンクリートグレー
            ],
            [
                'name' => 'Bistro Nippon',
                'domain' => 'order.bistronippon.tn',
                'theme_primary' => '#0047AB', // ビストロ風の深いブルー（仮）
                'theme_bg' => '#ffffff',      // クリーンな白
            ],
            [
                'name' => 'Curry Kitano',
                'domain' => 'currykitano.tn',
                'theme_primary' => '#E6A817', // スパイスイエロー（仮）
                'theme_bg' => '#FFF8E7',      // ウォームホワイト
            ],
        ];

        foreach ($tenants as $tenant) {
            Tenant::updateOrCreate(['domain' => $tenant['domain']], $tenant);
        }
    }
}

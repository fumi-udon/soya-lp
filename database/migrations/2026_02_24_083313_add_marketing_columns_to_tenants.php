<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('whatsapp_number')->nullable()->after('domain'); // 注文・予約用
            $table->string('store_code')->nullable()->after('whatsapp_number'); // システム連携用 (例: Bistro_Marsa)
            $table->string('instagram_url')->nullable()->after('store_code'); // SNSリンク用
            $table->string('address')->nullable()->after('instagram_url'); // 住所・マップ表示用
            $table->string('google_analytics_id')->nullable()->after('address'); // GA4タグ用 (例: G-XXXXXXX)
            $table->text('notice_message')->nullable()->after('google_analytics_id'); // 画面上部のお知らせバー用
        });
    }

    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'whatsapp_number',
                'store_code',
                'instagram_url',
                'address',
                'google_analytics_id',
                'notice_message'
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    // xxxx_create_orders_table.php
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // #A12B などの短い番号
            $table->string('customer_name');
            $table->string('customer_phone'); // WhatsApp番号（マーケティング用）
            $table->string('order_type');
            $table->text('notes')->nullable();
            $table->decimal('total_price', 10, 3);
            $table->string('status')->default('pending'); // pending, confirmed...
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

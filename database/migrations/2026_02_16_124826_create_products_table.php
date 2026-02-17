<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->string('name')->index();
            $table->string('staff_name')->nullable();
            $table->string('slug')->unique();
            $table->decimal('price', 10, 3)->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->text('ingredients')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('order_type', ["kitchen","counter"])->default('kitchen');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

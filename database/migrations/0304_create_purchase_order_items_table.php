<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::dropIfExists('purchase_order_items');

        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id('item_id')->unique();
            $table->foreignUuid('item_order'); //Constrained
            $table->string('item_product', 20); //Constrained
            $table->string('item_variant', 50); //Constrained
            $table->decimal('item_quantity', $precision = 12, $scale = 2)->default('0.00');
            $table->decimal('item_price', $precision = 12, $scale = 2)->default('0.00');
            $table->decimal('item_amount', $precision = 12, $scale = 2)->default('0.00');
            $table->string('created_by', 6); //Constrained
            $table->string('updated_by', 6); //Constrained
            $table->timestamps();

            $table->foreign('item_order')->references('order_id')->on('purchase_order_core')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('item_product')->references('product_index')->on('product_core')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('item_variant')->references('variant_index')->on('product_variants')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('created_by')->references('user_index')->on('system_users')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('updated_by')->references('user_index')->on('system_users')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};

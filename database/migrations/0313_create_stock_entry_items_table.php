<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::dropIfExists('stock_entry_items');

        Schema::create('stock_entry_items', function (Blueprint $table) {
            $table->id('item_id')->unique();
            $table->foreignUuid('item_entry'); //Constrained
            $table->string('item_product', 20); //Constrained
            $table->string('item_variant', 50); //Constrained
            $table->decimal('item_quantity', $precision = 12, $scale = 2)->default('0.00');
            $table->decimal('item_invoice_price', $precision = 12, $scale = 2)->default('0.00');
            $table->string('item_currency', 3); //Constrained
            $table->decimal('item_currency_rate', $precision = 20, $scale = 6)->default('0.000000');
            $table->decimal('item_converted_price', $precision = 20, $scale = 6)->default('0.000000');
            $table->decimal('item_costs', $precision = 20, $scale = 6)->default('0.000000');
            $table->decimal('item_purchase_price', $precision = 20, $scale = 6)->default('0.000000');
            $table->decimal('item_tax', $precision = 20, $scale = 6)->default('0.000000');
            $table->decimal('item_margin', $precision = 20, $scale = 6)->default('0.000000');
            $table->decimal('item_sale_price', $precision = 20, $scale = 6)->default('0.000000');
            $table->decimal('item_invoice_amount', $precision = 12, $scale = 2)->default('0.00');
            $table->decimal('item_converted_amount', $precision = 12, $scale = 2)->default('0.00');
            $table->decimal('item_cost_amount', $precision = 12, $scale = 2)->default('0.00');
            $table->decimal('item_purchase_amount', $precision = 12, $scale = 2)->default('0.00');
            $table->decimal('item_tax_amount', $precision = 12, $scale = 2)->default('0.00');
            $table->decimal('item_margin_amount', $precision = 12, $scale = 2)->default('0.00');
            $table->decimal('item_sale_amount', $precision = 12, $scale = 2)->default('0.00');
            $table->string('created_by', 6); //Constrained
            $table->string('updated_by', 6); //Constrained
            $table->timestamps();

            $table->foreign('item_entry')->references('entry_id')->on('stock_entry_core')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('item_product')->references('product_index')->on('product_core')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('item_variant')->references('variant_index')->on('product_variants')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('item_currency')->references('currency_index')->on('system_currencies')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('created_by')->references('user_index')->on('system_users')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('updated_by')->references('user_index')->on('system_users')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_entry_items');
    }
};

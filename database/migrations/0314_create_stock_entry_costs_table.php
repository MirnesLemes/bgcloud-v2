<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('stock_entry_costs');

        Schema::create('stock_entry_costs', function (Blueprint $table) {
            $table->id('cost_id')->unique();
            $table->foreignUuid('cost_entry'); //Constrained
            $table->integer('cost_partner'); //Constrained
            $table->string('cost_description', 100)->nullable();
            $table->decimal('cost_amount', $precision = 12, $scale = 2)->default('0.00');
            $table->string('cost_currency', 3); //Constrained
            $table->decimal('cost_currency_rate', $precision = 20, $scale = 6)->default('0.000000');
            $table->decimal('cost_converted_amount', $precision = 12, $scale = 2)->default('0.00');
            $table->string('created_by', 6); //Constrained
            $table->string('updated_by', 6); //Constrained
            $table->timestamps();

            $table->foreign('cost_entry')->references('entry_id')->on('stock_entry_core')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('cost_partner')->references('partner_index')->on('partner_core')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('cost_currency')->references('currency_index')->on('system_currencies')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('created_by')->references('user_index')->on('system_users')
                ->onUpdate('cascade')->onDelete('restrict');
    
            $table->foreign('updated_by')->references('user_index')->on('system_users')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_entry_costs');
    }
};

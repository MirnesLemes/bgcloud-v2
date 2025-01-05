<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::dropIfExists('stock_entry_core');
        
        Schema::create('stock_entry_core', function (Blueprint $table) {
            $table->uuid('entry_id')->primary();
            $table->string('entry_index', 20);
            $table->string('entry_type', 3); //Constrained
            $table->integer('entry_number');
            $table->date('entry_date');
            $table->integer('entry_partner'); //Constrained
            $table->integer('entry_warehouse'); //Constrained
            $table->string('entry_currency', 3); //Constrained
            $table->decimal('entry_currency_rate', $precision = 20, $scale = 6); 
            $table->string('entry_tax', 10); //Constrained           
            $table->decimal('entry_invoice_amount', $precision = 18, $scale = 2);
            $table->decimal('entry_converted_amount', $precision = 18, $scale = 2);
            $table->decimal('entry_cost_amount', $precision = 18, $scale = 2);
            $table->decimal('entry_purchase_amount', $precision = 18, $scale = 2);
            $table->decimal('entry_tax_amount', $precision = 18, $scale = 2);
            $table->decimal('entry_margin_amount', $precision = 18, $scale = 2);
            $table->decimal('entry_sale_amount', $precision = 18, $scale = 2);
            $table->string('entry_description', 500)->nullable();
            $table->integer('entry_status');
            $table->string('entry_doctype', 3); //Constrained
            $table->integer('entry_year'); //Constrained
            $table->integer('entry_month'); //Constrained
            $table->integer('entry_week'); 
            $table->string('created_by', 6); //Constrained
            $table->string('updated_by', 6); //Constrained
            $table->timestamps();

            $table->foreign('entry_type')->references('type_index')->on('stock_entry_types')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('entry_partner')->references('partner_index')->on('partner_core')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('entry_warehouse')->references('warehouse_index')->on('system_warehouses')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('entry_currency')->references('currency_index')->on('system_currencies')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('entry_tax')->references('tax_index')->on('system_taxes')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('entry_doctype')->references('type_index')->on('system_document_types')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('entry_year')->references('year_index')->on('system_years')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('entry_month')->references('month_index')->on('system_months')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('created_by')->references('user_index')->on('system_users')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('updated_by')->references('user_index')->on('system_users')
            ->onUpdate('cascade')->onDelete('restrict');
       
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_entry_core');
    }
};

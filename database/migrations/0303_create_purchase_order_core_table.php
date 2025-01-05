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
        Schema::dropIfExists('purchase_order_core');

        Schema::create('purchase_order_core', function (Blueprint $table) {
            $table->uuid('order_id')->primary();
            $table->string('order_index', 20);
            $table->string('order_type', 3); //Constrained
            $table->integer('order_number');
            $table->date('order_date');
            $table->date('order_deadline');
            $table->integer('order_partner'); //Constrained
            $table->integer('order_payment_term'); //Constrained
            $table->string('order_incoterm', 3); //Constrained
            $table->string('order_delivery', 250);
            $table->decimal('order_amount', $precision = 18, $scale = 2);
            $table->string('order_currency', 3); //Constrained
            $table->decimal('currency_rate', $precision = 20, $scale = 6)->default('0.000000');
            $table->string('order_description', 500)->nullable();
            $table->string('order_status', 3); //Constrained
            $table->string('order_doctype', 3); //Constrained
            $table->integer('order_year'); //Constrained
            $table->integer('order_month'); //Constrained
            $table->integer('order_week');
            $table->string('created_by', 6); //Constrained
            $table->string('updated_by', 6); //Constrained
            $table->timestamps();

            $table->foreign('order_type')->references('type_index')->on('purchase_order_types')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('order_partner')->references('partner_index')->on('partner_core')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('order_payment_term')->references('term_index')->on('system_payment_terms')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('order_incoterm')->references('incoterm_index')->on('system_incoterms')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('order_currency')->references('currency_index')->on('system_currencies')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('order_status')->references('status_index')->on('purchase_order_statuses')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('order_doctype')->references('type_index')->on('system_document_types')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('order_year')->references('year_index')->on('system_years')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('order_month')->references('month_index')->on('system_months')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('created_by')->references('user_index')->on('system_users')
                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('updated_by')->references('user_index')->on('system_users')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_order_core');
    }
};

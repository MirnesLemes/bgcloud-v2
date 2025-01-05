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
        Schema::dropIfExists('product_variants');
        
        Schema::create('product_variants', function (Blueprint $table) {
            $table->string('variant_index', 50)->primary();
            $table->string('variant_product', 20); //Constrained
            $table->string('variant_category', 6); //Constrained
            $table->string('variant_uom', 6); //Constrained
            $table->string('variant_packing', 6); //Constrained
            $table->string('variant_brand', 6); //Constrained
            $table->string('variant_origin', 2); //Constrained
            $table->integer('variant_code');
            $table->string('variant_name', 100);
            $table->string('variant_barcode', 20)->nullable();
            $table->string('variant_hscode', 20)->nullable();
            $table->integer('uom_quantity');
            $table->decimal('variant_weight', $precision = 12, $scale = 2)->default('0.00');
            $table->decimal('variant_price', $precision = 12, $scale = 2)->default('0.00');
            $table->decimal('variant_taxprice', $precision = 12, $scale = 2)->default('0.00');
            $table->decimal('variant_expprice', $precision = 12, $scale = 2)->default('0.00');
            $table->string('variant_expprice_currency', 3); //Constrained
            $table->decimal('variant_purprice', $precision = 12, $scale = 2)->default('0.00');
            $table->decimal('variant_supprice', $precision = 12, $scale = 2)->default('0.00');
            $table->string('variant_supprice_currency', 3); //Constrained
            $table->string('variant_a1_index', 50)->nullable(); 
            $table->string('variant_a1_value', 200)->nullable();
            $table->string('variant_a2_index', 50)->nullable(); 
            $table->string('variant_a2_value', 200)->nullable();
            $table->string('variant_a3_index', 50)->nullable(); 
            $table->string('variant_a3_value', 200)->nullable();
            $table->string('variant_a4_index', 50)->nullable(); 
            $table->string('variant_a4_value', 200)->nullable();
            $table->integer('ordering');
            $table->string('created_by', 6);
            $table->string('updated_by', 6);
            $table->timestamps();

            $table->foreign('variant_product')->references('product_index')->on('product_core')
                                                ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('variant_category')->references('category_index')->on('product_categories')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('variant_uom')->references('uom_index')->on('product_uoms')
                                            ->onUpdate('cascade')->onDelete('restrict');     
                                            
            $table->foreign('variant_packing')->references('packing_index')->on('product_packings')
                                            ->onUpdate('cascade')->onDelete('restrict'); 

            $table->foreign('variant_origin')->references('country_index')->on('partner_countries')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('variant_brand')->references('brand_index')->on('product_brands')
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
        Schema::dropIfExists('product_variants');
    }

};

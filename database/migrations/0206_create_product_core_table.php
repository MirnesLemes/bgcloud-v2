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
        Schema::dropIfExists('product_core');
        
        Schema::create('product_core', function (Blueprint $table) {
            $table->string('product_index', 20)->primary();
            $table->string('product_category', 6); //Constrained
            $table->string('product_brand', 6); //Constrained
            $table->string('product_name', 100);
            $table->string('product_description', 500);
            $table->longText('product_text')->nullable();
            $table->string('product_tags', 500)->nullable();
            $table->string('product_thumbnail', 200)->nullable();
            $table->string('product_video', 200)->nullable();
            $table->string('product_a1_name', 50)->nullable(); 
            $table->string('product_a2_name', 50)->nullable(); 
            $table->string('product_a3_name', 50)->nullable(); 
            $table->string('product_a4_name', 50)->nullable();
            $table->string('product_a1_values', 500)->nullable(); 
            $table->string('product_a2_values', 500)->nullable(); 
            $table->string('product_a3_values', 500)->nullable(); 
            $table->string('product_a4_values', 500)->nullable();  
            $table->tinyInteger('published')->default(1);
            $table->tinyInteger('featured')->default(0);  
            $table->tinyInteger('onsale')->default(0);        
            $table->integer('ordering');
            $table->string('created_by', 6);
            $table->string('updated_by', 6);
            $table->timestamps();

            $table->foreign('product_category')->references('category_index')->on('product_categories')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('product_brand')->references('brand_index')->on('product_brands')
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
        Schema::dropIfExists('product_core');
    }

};

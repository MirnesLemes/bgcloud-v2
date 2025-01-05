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
        Schema::dropIfExists('system_years');
        
        Schema::create('system_years', function (Blueprint $table) {
            $table->integer('year_index')->primary();
            $table->string('year_name', 50);
            $table->string('created_by', 6);
            $table->string('updated_by', 6);
            $table->timestamps();

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
        Schema::dropIfExists('system_years');
    }

};

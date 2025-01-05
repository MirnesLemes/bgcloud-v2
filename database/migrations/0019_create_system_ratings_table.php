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
        Schema::dropIfExists('system_ratings');
        
        Schema::create('system_ratings', function (Blueprint $table) {
            $table->integer('rating_index')->primary();
            $table->string('rating_name', 100);
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
        Schema::dropIfExists('system_ratings');
    }

};

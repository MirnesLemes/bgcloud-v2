<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::dropIfExists('stock_entry_types');
        
        Schema::create('stock_entry_types', function (Blueprint $table) {
            $table->string('type_index', 3)->primary();
            $table->string('type_name', 100);
            $table->integer('ordering');
            $table->string('created_by', 6); //Constrained
            $table->string('updated_by', 6); //Constrained
            $table->timestamps();

            $table->foreign('created_by')->references('user_index')->on('system_users')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('updated_by')->references('user_index')->on('system_users')
            ->onUpdate('cascade')->onDelete('restrict');
       
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_entry_types');
    }
};

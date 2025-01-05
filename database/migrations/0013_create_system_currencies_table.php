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
        Schema::dropIfExists('system_currencies');
        
        Schema::create('system_currencies', function (Blueprint $table) {
            $table->string('currency_index', 3)->primary();
            $table->string('currency_name', 50);
            $table->decimal('currency_rate', $precision = 20, $scale = 6)->default('0.000000');
            $table->integer('ordering');
            $table->integer('default');
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
        Schema::dropIfExists('system_currencies');
    }
    
};

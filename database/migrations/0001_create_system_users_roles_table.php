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
        Schema::dropIfExists('system_users_roles');
        
        Schema::create('system_users_roles', function (Blueprint $table) {
            
            $table->string('role_index', 30)->primary();
            $table->string('role_name', 50);
            $table->integer('ordering');
            $table->timestamps();
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_users_roles');
    }

};

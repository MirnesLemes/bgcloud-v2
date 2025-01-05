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
        Schema::dropIfExists('system_users');
        
        Schema::create('system_users', function (Blueprint $table) {

            $table->string('user_index', 6)->primary();
            $table->string('user_name', 50);
            $table->string('user_email', 50)->unique(); 
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user_password', 100);
            $table->string('user_role', 30);
            $table->tinyInteger('approved')->default(0);
            $table->string('avatar_url', 200)->nullable();
            $table->integer('ordering')->default(1);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('user_role')->references('role_index')->on('system_users_roles')
            ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_users');
    }
};

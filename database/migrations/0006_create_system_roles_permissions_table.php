<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('system_roles_permissions', function (Blueprint $table) {
            $table->id('permission_id')->unique();
            $table->string('permission_role', 30);
            $table->string('permission_model');
            $table->json('permission_permissions'); 
            $table->timestamps();

            $table->foreign('permission_role')->references('role_index')->on('system_users_roles')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_roles_permissions');
    }
};

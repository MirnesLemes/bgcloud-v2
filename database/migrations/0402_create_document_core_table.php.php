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
        Schema::create('document_core', function (Blueprint $table) {
            $table->id('document_id')->unique();
            $table->string('document_name', 50);
            $table->date('document_date');
            $table->string('document_category', 6); //Constrained
            $table->integer('document_partner'); //Constrained
            $table->string('document_description', 500);
            $table->string('document_users', 200);
            $table->string('document_url', 200)->nullable(); 
            $table->string('document_full_url', 200)->nullable(); 
            $table->string('created_by', 6); //Constrained
            $table->string('updated_by', 6); //Constrained
            $table->timestamps();

            $table->foreign('document_category')->references('category_index')->on('document_categories')
            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('document_partner')->references('partner_index')->on('partner_core')
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
        Schema::dropIfExists('document_core');
    }
};

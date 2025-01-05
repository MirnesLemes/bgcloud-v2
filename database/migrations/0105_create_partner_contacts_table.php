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
        Schema::dropIfExists('partner_contacts');
        
        Schema::create('partner_contacts', function (Blueprint $table) {
            $table->id('contact_id')->unique();
            $table->integer('contact_partner'); //Constrained
            $table->string('contact_name', 50);
            $table->string('contact_workplace', 50);
            $table->string('contact_phone', 30)->nullable();
            $table->string('contact_mobile', 30);
            $table->string('contact_mail', 50);
            $table->integer('ordering');
            $table->string('created_by', 6); //Constrained
            $table->string('updated_by', 6); //Constrained
            $table->timestamps();

            $table->foreign('contact_partner')->references('partner_index')->on('partner_core')
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
        Schema::dropIfExists('partner_contacts');
    }

};

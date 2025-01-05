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
        Schema::dropIfExists('partner_communications');
        
        Schema::create('partner_communications', function (Blueprint $table) {
            $table->id('communication_id');
            $table->integer('communication_partner'); //Constrained
            $table->bigInteger('communication_contact')->unsigned(); //Constrained
            $table->string('communication_method', 30);
            $table->date('communication_date');
            $table->time('communication_starting_time');
            $table->time('communication_ending_time');
            $table->string('communication_description', 500)->nullable();
            $table->integer('communication_rating'); //Constrained
            $table->integer('ordering');
            $table->string('created_by', 6); //Constrained
            $table->string('updated_by', 6); //Constrained
            $table->timestamps();

            $table->foreign('communication_partner')->references('partner_index')->on('partner_core')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('communication_contact')->references('contact_id')->on('partner_contacts')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('communication_rating')->references('rating_index')->on('system_ratings')
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
        Schema::dropIfExists('partner_communications');
    }

};

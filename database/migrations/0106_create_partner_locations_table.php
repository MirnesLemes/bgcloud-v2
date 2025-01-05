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
        Schema::dropIfExists('partner_locations');
        
        Schema::create('partner_locations', function (Blueprint $table) {
            $table->id('location_id');
            $table->integer('location_partner'); //Constrained
            $table->string('location_name', 100);
            $table->string('location_jib', 20)->nullable();
            $table->string('location_address', 100);
            $table->string('location_city', 15); //Constrained
            $table->string('location_geolocation', 100)->nullable();
            $table->integer('ordering');
            $table->string('created_by', 6); //Constrained
            $table->string('updated_by', 6); //Constrained
            $table->timestamps();

            $table->foreign('location_partner')->references('partner_index')->on('partner_core')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('location_city')->references('city_index')->on('partner_cities')
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
        Schema::dropIfExists('partner_locations');
    }

};

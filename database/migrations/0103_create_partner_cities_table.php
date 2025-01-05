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
        Schema::dropIfExists('partner_cities');
        
        Schema::create('partner_cities', function (Blueprint $table) {
            $table->string('city_index', 15)->primary();
            $table->string('city_name', 100);
            $table->string('city_zip', 10);
            $table->string('city_country', 2);
            $table->string('city_region', 6);
            $table->integer('ordering');
            $table->string('created_by', 6);
            $table->string('updated_by', 6);
            $table->timestamps();

            $table->foreign('city_country')->references('country_index')->on('partner_countries')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('city_region')->references('region_index')->on('partner_regions')
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
        Schema::dropIfExists('partner_cities');
    }

};

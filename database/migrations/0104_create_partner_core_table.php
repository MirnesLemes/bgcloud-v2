<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::dropIfExists('partner_core');
        
        Schema::create('partner_core', function (Blueprint $table) {
            $table->integer('partner_index')->primary();
            $table->string('partner_name', 100);
            $table->string('partner_fullname', 255)->nullable();
            $table->string('partner_address', 255);
            $table->string('partner_city', 15); //Constrained
            $table->string('partner_country', 2); //Constrained
            $table->string('partner_region', 6); //Constrained
            $table->string('partner_user', 6); //Constrained  
            $table->string('partner_jib', 20)->nullable(); 
            $table->string('partner_pib', 20)->nullable();
            $table->string('partner_mbs', 20)->nullable();
            $table->string('partner_phone', 30)->nullable();
            $table->string('partner_fax', 30)->nullable();
            $table->string('partner_mail', 50)->nullable();
            $table->string('partner_web', 50)->nullable();
            $table->string('partner_contract', 30)->nullable();
            $table->decimal('partner_discount', $precision = 4, $scale = 2)->default('0.00');
            $table->integer('partner_payment_term')->default(0); //Constrained
            $table->string('partner_incoterm', 3)->nullable(); //Constrained
            $table->string('partner_tax', 10)->nullable(); //Constrained
            $table->decimal('partner_limit', $precision = 18, $scale = 2)->default('0.00');
            $table->string('created_by', 6); //Constrained
            $table->string('updated_by', 6); //Constrained
            $table->timestamps();

            $table->foreign('partner_city')->references('city_index')->on('partner_cities')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('partner_country')->references('country_index')->on('partner_countries')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('partner_region')->references('region_index')->on('partner_regions')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('partner_user')->references('user_index')->on('system_users')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('partner_payment_term')->references('term_index')->on('system_payment_terms')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('partner_incoterm')->references('incoterm_index')->on('system_incoterms')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('partner_tax')->references('tax_index')->on('system_taxes')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('created_by')->references('user_index')->on('system_users')
                                            ->onUpdate('cascade')->onDelete('restrict');

            $table->foreign('updated_by')->references('user_index')->on('system_users')
                                            ->onUpdate('cascade')->onDelete('restrict');        
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_core');
    }

};

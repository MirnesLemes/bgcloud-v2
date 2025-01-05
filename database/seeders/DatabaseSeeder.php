<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            
            //System
            SystemUserRolesSeeder::class, //0001
            SystemUsersSeeder::class, //0002
            SytemYearsSeeder::class, //0011
            SystemMonthsSeeder::class, //0012
            SystemCurrenciesSeeder::class, //0013 
            SystemPaymentMethodsSeeder::class, //0014  
            SystemPaymentTermsSeeder::class, //0015      
            SystemIncotermsSeeder::class, //0016           
            SystemTaxesSeeder::class, //0017
            SystemCommunicationMethodsSeeder::class, //0018
            SystemRatingsSeeder::class, //0019
            SytemDocumentTypesSeeder::class, //0020

            //Partners
            PartnerCountriesSeeder::class, //0101
            PartnerRegionsSeeder::class, //0102
            PartnerCitiesSeeder::class, //0103
            PartnerCoreSeeder::class, //0104
            PartnerContactsSeeder::class, //0105
            ParnerLocationSeeder::class, //0106

            // //Purchase
            PurchaseOrderTypesSeeder::class, //0301
            PurchaseOrderStatusesSeeder::class, //0302
            
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PartnerCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    
        DB::table('partner_cities')->insert([
            'city_index' => 'BA71300',
            'city_name' => 'Visoko',
            'city_zip' => '71300',
            'city_country' => 'BA',
            'city_region' => 'CENBOS',
            'ordering' => '1',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('partner_cities')->insert([
            'city_index' => 'BA71000',
            'city_name' => 'Sarajevo',
            'city_zip' => '71000',
            'city_country' => 'BA',
            'city_region' => 'REGSAR',
            'ordering' => '2',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('partner_cities')->insert([
            'city_index' => 'BA72000',
            'city_name' => 'Zenica',
            'city_zip' => '72000',
            'city_country' => 'BA',
            'city_region' => 'CENBOS',
            'ordering' => '3',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

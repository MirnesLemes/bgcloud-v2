<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PartnerCountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('partner_countries')->insert([
            'country_index' => 'BA',
            'country_name' => 'Bosna i Hercegovina',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('partner_countries')->insert([
            'country_index' => 'HR',
            'country_name' => 'Republika Hrvatska',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('partner_countries')->insert([
            'country_index' => 'RS',
            'country_name' => 'Republika Srbija',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('partner_countries')->insert([
            'country_index' => 'PL',
            'country_name' => 'Poland',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

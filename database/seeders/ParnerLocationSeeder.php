<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ParnerLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('partner_locations')->insert([
            'location_partner' => '10001',
            'location_name' => 'Uprava i skladište',
            'location_jib' => '',
            'location_address' => 'Čajengradska bb',
            'location_city' => 'BA71300',
            'location_geolocation' => '43.9940005455262, 18.186655064972122',
            'ordering' => '1',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

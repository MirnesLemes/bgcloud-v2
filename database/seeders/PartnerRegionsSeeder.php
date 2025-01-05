<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PartnerRegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('partner_regions')->insert([
            'region_index' => 'CENBOS',
            'region_name' => 'Centralna Bosna',
            'region_user' => 'POCADM',
            'ordering' => '1',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('partner_regions')->insert([
            'region_index' => 'REGSAR',
            'region_name' => 'Regija Sarajevo',
            'region_user' => 'POCADM',
            'ordering' => '2',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('partner_regions')->insert([
            'region_index' => 'REGTUZ',
            'region_name' => 'Regija Tuzla',
            'region_user' => 'POCADM',
            'ordering' => '3',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('partner_regions')->insert([
            'region_index' => 'REGDOB',
            'region_name' => 'Regija Doboj',
            'region_user' => 'POCADM',
            'ordering' => '4',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('partner_regions')->insert([
            'region_index' => 'REGKRA',
            'region_name' => 'Regija Krajina',
            'region_user' => 'POCADM',
            'ordering' => '5',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('partner_regions')->insert([
            'region_index' => 'ISTHER',
            'region_name' => 'Istočna Hercegovina',
            'region_user' => 'POCADM',
            'ordering' => '6',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('partner_regions')->insert([
            'region_index' => 'ZAPHER',
            'region_name' => 'Zapadna Hercegovina',
            'region_user' => 'POCADM',
            'ordering' => '7',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('partner_regions')->insert([
            'region_index' => 'REGINO',
            'region_name' => 'Inostranstvo',
            'region_user' => 'POCADM',
            'ordering' => '8',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

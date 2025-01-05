<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemTaxesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('system_taxes')->insert([
            'tax_index' => 'PDV17',
            'tax_name' => 'Pdv 17%',
            'tax_description' => 'Standardni porez na proizvode i usluge 17%',
            'tax_rate' => '17.00',
            'ordering' => '1',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_taxes')->insert([
            'tax_index' => 'PDV00',
            'tax_name' => 'Pdv 0%',
            'tax_description' => 'Oslobođeno od plaćanja poreza',
            'tax_rate' => '0.00',
            'ordering' => '2',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

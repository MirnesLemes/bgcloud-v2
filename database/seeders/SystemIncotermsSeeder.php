<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemIncotermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('system_incoterms')->insert([
            'incoterm_index' => 'FCA',
            'incoterm_name' => 'FCA skladište prodavca',
            'incoterm_description' => 'FCA skladište prodavca, utovareno na vozilo kupca',
            'ordering' => '1',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_incoterms')->insert([
            'incoterm_index' => 'CPT',
            'incoterm_name' => 'CPT skladište kupca',
            'incoterm_description' => 'CPT skladište kupca, neistovareno sa vozila prodavca',
            'ordering' => '2',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

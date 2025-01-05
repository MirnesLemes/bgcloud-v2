<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemCommunicationMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('system_communication_methods')->insert([
            'method_index' => 'POS', 
            'method_name' => 'Posjeta partneru',
            'ordering' => 1,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_communication_methods')->insert([
            'method_index' => 'OBI', 
            'method_name' => 'Obilazak lokacije',
            'ordering' => 2,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_communication_methods')->insert([
            'method_index' => 'TEL', 
            'method_name' => 'Telefonska komunikacija',
            'ordering' => 3,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_communication_methods')->insert([
            'method_index' => 'EML', 
            'method_name' => 'E-mail komunikacija',
            'ordering' => 4,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_communication_methods')->insert([
            'method_index' => 'KON', 
            'method_name' => 'Video konferencija',
            'ordering' => 5,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_communication_methods')->insert([
            'method_index' => 'DOL', 
            'method_name' => 'Dolazak partnera',
            'ordering' => 6,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

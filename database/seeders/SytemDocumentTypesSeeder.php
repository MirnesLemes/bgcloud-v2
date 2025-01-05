<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SytemDocumentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('system_document_types')->insert([
            'type_index' => 'NRD', 
            'type_name' => 'Narudžba dobavljaču',
            'ordering' => 1,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_document_types')->insert([
            'type_index' => 'PON', 
            'type_name' => 'Ponuda kupcu',
            'ordering' => 2,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_document_types')->insert([
            'type_index' => 'PRN', 
            'type_name' => 'Prodajni nalog',
            'ordering' => 3,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_document_types')->insert([
            'type_index' => 'OTP', 
            'type_name' => 'Otpremnica robe',
            'ordering' => 4,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_document_types')->insert([
            'type_index' => 'VPR', 
            'type_name' => 'Veleprodajni račun',
            'ordering' => 5,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_document_types')->insert([
            'type_index' => 'MPR', 
            'type_name' => 'Maloprodajni račun',
            'ordering' => 6,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_document_types')->insert([
            'type_index' => 'IZR', 
            'type_name' => 'Izvozni račun',
            'ordering' => 7,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_document_types')->insert([
            'type_index' => 'ULR', 
            'type_name' => 'Ulazni račun',
            'ordering' => 8,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

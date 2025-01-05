<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemPaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('system_payment_methods')->insert([
            'method_index' => 'VIR',
            'method_name' => 'Virmansko plaćanje na banku',
            'ordering' => '1',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_payment_methods')->insert([
            'method_index' => 'GOT',
            'method_name' => 'Gotovinsko plaćanje na blagajnu',
            'ordering' => '2',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_payment_methods')->insert([
            'method_index' => 'KAR',
            'method_name' => 'Kartično plaćanje na banku',
            'ordering' => '3',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

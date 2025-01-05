<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PurchaseOrderStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('purchase_order_statuses')->insert([
            'status_index' => 'NAC', 
            'status_name' => 'Nacrt',
            'ordering' => 1,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('purchase_order_statuses')->insert([
            'status_index' => 'POS', 
            'status_name' => 'Poslana',
            'ordering' => 2,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('purchase_order_statuses')->insert([
            'status_index' => 'POT', 
            'status_name' => 'Potvrđena',
            'ordering' => 3,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('purchase_order_statuses')->insert([
            'status_index' => 'DOL', 
            'status_name' => 'U dolasku',
            'ordering' => 4,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('purchase_order_statuses')->insert([
            'status_index' => 'REA', 
            'status_name' => 'Realizovana',
            'ordering' => 5,
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

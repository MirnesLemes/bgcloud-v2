<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemPaymentTermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('system_payment_terms')->insert([
            'term_index' => '0',
            'term_name' => 'Avans',
            'term_description' => 'Avansno plaćanje prilikom narudžbe',
            'ordering' => '1',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_payment_terms')->insert([
            'term_index' => '7',
            'term_name' => '7 dana',
            'term_description' => 'Odloženo plaćanje do 7 dana po ispostavljenoj fakturi',
            'ordering' => '2',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_payment_terms')->insert([
            'term_index' => '14',
            'term_name' => '14 dana',
            'term_description' => 'Odloženo plaćanje do 14 dana po ispostavljenoj fakturi',
            'ordering' => '3',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_payment_terms')->insert([
            'term_index' => '30',
            'term_name' => '30 dana',
            'term_description' => 'Odloženo plaćanje do 30 dana po ispostavljenoj fakturi',
            'ordering' => '4',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_payment_terms')->insert([
            'term_index' => '45',
            'term_name' => '45 dana',
            'term_description' => 'Odloženo plaćanje do 45 dana po ispostavljenoj fakturi',
            'ordering' => '5',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_payment_terms')->insert([
            'term_index' => '60',
            'term_name' => '60 dana',
            'term_description' => 'Odloženo plaćanje do 60 dana po ispostavljenoj fakturi',
            'ordering' => '6',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_payment_terms')->insert([
            'term_index' => '90',
            'term_name' => '90 dana',
            'term_description' => 'Odloženo plaćanje do 90 dana po ispostavljenoj fakturi',
            'ordering' => '7',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

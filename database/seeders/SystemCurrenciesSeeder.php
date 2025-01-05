<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemCurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('system_currencies')->insert([
            'currency_index' => 'BAM',
            'currency_name' => 'Konvertibilna marka',
            'currency_rate' => '1.000000',
            'ordering' => '1',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_currencies')->insert([
            'currency_index' => 'EUR',
            'currency_name' => 'Evropski euro',
            'currency_rate' => '1.95583',
            'ordering' => '2',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

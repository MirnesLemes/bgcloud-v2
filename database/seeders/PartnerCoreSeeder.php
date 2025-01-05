<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PartnerCoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('partner_core')->insert([
            'partner_index' => '10001',
            'partner_name' => 'Baltic Group d.o.o.',
            'partner_fullname' => 'Društvo za proizvodnju, trgovinu i usluge "BALTIC GROUP" d.o.o. Visoko',
            'partner_address' => 'Čajengradska bb',
            'partner_city' => 'BA71300',
            'partner_country' => 'BA',
            'partner_region' => 'CENBOS',
            'partner_user' => 'POCADM',
            'partner_jib' => '4218849440004',
            'partner_pib' => '218849440004',
            'partner_mbs' => '43-01-0204-14',
            'partner_phone' => '+387 32 730 430',
            'partner_fax' => '+387 32 730 431',
            'partner_mail' => 'office@baltic.group',
            'partner_web' => 'http://baltic.group',
            'partner_contract' => '00152/2023',
            'partner_discount' => '50.00',
            'partner_payment_discount' => '5.00',
            'partner_payment_term' => '60',
            'partner_incoterm' => 'FCA',
            'partner_tax' => 'PDV17',
            'partner_limit' => '30000.00',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

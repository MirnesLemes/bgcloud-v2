<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PartnerContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('partner_contacts')->insert([
            'contact_partner' => '10001',
            'contact_name' => 'Mevlana Lemeš',
            'contact_workplace' => 'Direktor Društva',
            'contact_phone' => '+387 32 730 430',
            'contact_mobile' => '+387 61 409 916',
            'contact_mail' => 'mevlana@baltic.group',
            'ordering' => '1',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('partner_contacts')->insert([
            'contact_partner' => '10001',
            'contact_name' => 'Mirnes Lemeš',
            'contact_workplace' => 'Direktor Marketinga',
            'contact_phone' => '+387 32 730 430',
            'contact_mobile' => '+387 61 247 257',
            'contact_mail' => 'mirnes@baltic.group',
            'ordering' => '2',
            'created_by' => 'POCADM',
            'updated_by' => 'POCADM',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

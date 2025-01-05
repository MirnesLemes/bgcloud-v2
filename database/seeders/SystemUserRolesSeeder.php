<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('system_users_roles')->insert([
            'role_index' => 'ADMIN', 
            'role_name' => 'Administrator',
            'ordering' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_users_roles')->insert([
            'role_index' => 'COORDINATOR', 
            'role_name' => 'Koordinator',
            'ordering' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_users_roles')->insert([
            'role_index' => 'SALESMANAGER', 
            'role_name' => 'Voditelj prodaje',
            'ordering' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_users_roles')->insert([
            'role_index' => 'SALESREPRESENTATIVE', 
            'role_name' => 'Prodajni agent',
            'ordering' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_users_roles')->insert([
            'role_index' => 'TECHNICALSUPPORT', 
            'role_name' => 'Tehnička podrška',
            'ordering' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_users_roles')->insert([
            'role_index' => 'CLIENT', 
            'role_name' => 'Kupac',
            'ordering' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('system_users_roles')->insert([
            'role_index' => 'GUEST', 
            'role_name' => 'Gost',
            'ordering' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

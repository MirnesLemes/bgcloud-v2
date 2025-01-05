<?php

namespace Database\Seeders;

use App\Models\System\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class SystemUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('system_users')->insert([
            'user_index' => 'POCADM',
            'user_name' => 'Početni administrator',
            'user_email' => 'admin@test.ba',
            'user_password' => Hash::make('12345678'),          
            'user_role' => 'ADMIN',
            'approved' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}

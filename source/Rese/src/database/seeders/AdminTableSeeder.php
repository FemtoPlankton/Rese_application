<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 管理者のみを登録
        DB::table('users')->insert([
            'id' => Str::uuid()->toString(),
            'role' => 'admin',
            'name' => '管理者',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin1234'),
        ]);
    }
}

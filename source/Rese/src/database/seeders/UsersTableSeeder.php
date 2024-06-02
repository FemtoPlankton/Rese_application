<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder
;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;



class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            '高橋 あゆみ', '高橋 次郎', '田中 和也', '山本 さくら', '中村 優子',
            '小林 花子', '山本 太郎', '山本 花子', '加藤 涼', '小林 直樹',
            '加藤 花子', '鈴木 直樹', '加藤 優子', '中村 太郎', '吉田 さくら',
            '高橋 和也', '佐藤 健太', '中村 あゆみ', '小林 あゆみ', '山本 直樹',
        ];

        $password = Str::random(10);

        foreach ($names as $name) {
            User::create([
                'id' => Str::uuid()->toString(),
                'name' => $name,
                'email' => Str::random(10) . '@example.com',
                'password' => Hash::make($password)
            ]);
        }
    }
}

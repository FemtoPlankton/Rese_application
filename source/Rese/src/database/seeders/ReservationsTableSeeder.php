<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // ユーザーのお気に入りレストランを取得
            $favoriteRestaurantIds = $user->favorites()->pluck('restaurant_id');

            // お気に入りがなければスキップ
            if ($favoriteRestaurantIds->isEmpty()) {
                continue;
            }

            // 0〜1のランダムで予約を作成するか決定
            if (rand(0, 1) === 1) {
                // お気に入りからランダムに1つ選択
                $restaurantId = $favoriteRestaurantIds->random();

                // 予約日時を設定（日付と時刻を組み合わせる）
                $reservationDateTime = now()->addDays(rand(1, 30))->setHour(rand(11, 20))->setMinute(0)->setSecond(0);

                // 予約データの作成
                Reservation::create([
                    'user_id' => $user->id,
                    'restaurant_id' => $restaurantId,
                    'date' => $reservationDateTime, // 組み合わせた日時を 'date' フィールドに設定
                    'number_of_people' => rand(1, 6), // 1〜6人のランダムな人数
                ]);
            }
        }
    }
}

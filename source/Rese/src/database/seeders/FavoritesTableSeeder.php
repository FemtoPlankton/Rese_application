<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Favorite;
use Illuminate\Support\Facades\DB;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $restaurantIds = Restaurant::pluck('id');

        foreach ($users as $user) {
            $favoritesCount = rand(0, 5);

            for($i = 0; $i < $favoritesCount; $i++) {
                $restaurantId = $restaurantIds->random();

                $exists = Favorite::where('user_id', $user->id)->where('restaurant_id', $restaurantId)->exists();

                if (!$exists) {
                    Favorite::create([
                        'user_id' => $user->id,
                        'restaurant_id' => $restaurantId,
                    ]);
                }
            }
        }
    }
}

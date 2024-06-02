<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Favorite;
use Carbon\Carbon;

class FavoriteController extends Controller
{
    public function addFavorite(Request $request, string $restaurantId)
    {
        $user = auth()->user();

        try {
            $user->favoriteRestaurants()->attach($restaurantId, ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
            return response()->json(['status' => 'Added to favorites']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add to favorites'], 400);
        }
    }

    public function deleteFavorite(Request $request, string $restaurantId)
    {
        $user = auth()->user();

        try {
            $user->favoriteRestaurants()->detach($restaurantId);
            return response()->json(['status' => 'Removed from favorites']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to remove from favorites'], 400);
        }
    }
}
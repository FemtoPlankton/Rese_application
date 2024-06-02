<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Reservation;
use App\Models\Restaurant;

class MypageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $restaurants = Restaurant::all();
        $favorites = $user->favorites()->get();
        $reservations = $user->reservations()->withTrashed()->with('restaurant')->orderBy('date')->orderBy('time')->get();

        return view('mypage', compact('restaurants', 'reservations', 'favorites'));
    }

    public function addFavorite(Request $request, string $restaurantId)
    {
        $user = auth()->user();

        try {
            $user->favoriteRestaurants()->attach($restaurantId);
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
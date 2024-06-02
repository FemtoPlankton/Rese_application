<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Restaurant;
use Faker\Provider\ar_SA\Internet;
use Illuminate\View\View;
use Carbon\Carbon;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::all();
        $genres = Genre::all();
        $query = Restaurant::with(['area', 'genre'])
                                ->withCount('favorites')
                                ->orderBy('order_id', 'asc');
        $user = auth()->user();

        if ($request->filled('genre')) {
            $query->whereHas('genre', function ($query) use ($request) {
                $query->where('id', $request->genre);
            });
        }

        if ($request->filled('area')) {
            $query->whereHas('area', function ($query) use ($request) {
                $query->where('id', $request->area);
            });
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        $query->orderBy('order_id', 'asc');

        $restaurants = $query->get();

        return view('index', compact('areas', 'genres', 'restaurants', 'user'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!empty($search)) {
            $results = Restaurant::where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->get();
        } else {
            $results = Restaurant::all();
        }

        return response()->json($results);
    }

    public function show($restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        return view('restaurant-detail', compact('restaurant'));
    }
}
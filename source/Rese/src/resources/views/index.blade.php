<x-header-index :genres="$genres" :areas="$areas">
    <div class="container px-4 mx-auto mt-6 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4 lg:grid-cols-3">
            @foreach ($restaurants as $restaurant)
                <div
                    class="overflow-hidden transition-shadow duration-300 ease-in-out bg-white rounded-lg shadow-md hover:shadow-lg">
                    <img class="object-cover w-full h-48" src="{{ $restaurant->image_url }}" alt="店舗の写真">
                    <div class="p-4">
                        <h2 class="mb-2 text-lg font-bold">{{ $restaurant->name }}</h2>
                        <p class="mb-4 text-sm text-gray-600">
                            <a
                                href="{{ route('restaurants.index', ['area' => $restaurant->area->id]) }}">#{{ $restaurant->area->name }}</a>
                            <a
                                href="{{ route('restaurants.index', ['genre' => $restaurant->genre->id]) }}">#{{ $restaurant->genre->name }}</a>
                        </p>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('restaurants.show', $restaurant) }}"
                                class="inline-block px-4 py-2 text-sm font-bold text-center text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                                詳しくみる
                            </a>
                            <div class="-mt-4">
                                @csrf
                                @auth
                                <button type="submit" class="text-xl favorite-button"
                                    data-restaurant="{{ $restaurant->id }}"
                                    data-favorited="{{ $user->favorites()->where('restaurant_id', $restaurant->id)->exists()? 'true': 'false' }}"
                                    data-favorite-url="{{ route('favorite.store', $restaurant->id) }}"
                                    data-unfavorite-url="{{ route('favorite.destroy', $restaurant->id) }}">
                                    <i
                                        class="fa-sharp fa-solid fa-heart fa-2xl mt-8 {{ $user->favorites()->where('restaurant_id', $restaurant->id)->exists()? 'icon-red': 'icon-grey' }}">
                                    </i>
                                </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-header-index>

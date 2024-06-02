<x-header-app>
    <div class="container mx-auto mt-8">

        @php
            $sessionMessage = session('success') ?? (session('error') ?? null);
        @endphp

        <div id="message-overlay" class="fixed top-0 left-0 z-50 hidden w-full h-full bg-white bg-opacity-50">
            <div id="message-box"
                class="absolute p-6 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded shadow-md top-1/2 left-1/2 ">
                <p id="message-content" class="mx-auto mb-4 text-lg"></p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="mx-auto mb-4">{{ $error }}</li>
                    @endforeach
                </ul>
                <button id="ok-button"
                    class="block px-4 py-2 m-auto text-white bg-blue-500 rounded cursor-pointer">OK</button>
            </div>
        </div>

        <div class="mx-8 md:flex">
            {{-- 予約状況セクション --}}
            <div class="w-full p-4 md:w-5/12">
                <h2 class="mb-4 text-xl font-bold">予約状況</h2>
                @if ($reservations->isEmpty())
                    <p>予約がありません</p>
                @endif
                @foreach ($reservations as $index => $reservation)
                    <div class="flex flex-col mb-8" data-reservation-Id="{{ $index + 1 }}">
                        <div class="relative">
                            <div class="p-6 text-white bg-blue-600 rounded-lg {{ $reservation->trashed() ? 'opacity-50 pointer-events-none' : '' }}  reservation-card"
                                data-reservation-Id="{{ $reservation->id }}">

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center ml-3">
                                        <i class="mr-4 fa-light fa-clock fa-xl"></i>
                                        <p>予約{{ $index + 1 }}</p>
                                    </div>
                                    <i class="mr-2 cursor-pointer fa-light fa-circle-xmark fa-xl cancel-reservation"
                                        data-reservation-id="{{ $reservation->id }}"></i>
                                </div>

                                <div>
                                    <div id="editable-section" class="hidden p-3 rounded-md editable-section">
                                        <div class="flex items-end justify-between">
                                            <div>
                                                <p>Shop: {{ $reservation->restaurant->name }}</p>
                                                <form method="POST" id="form-{{ $reservation->id }}"
                                                    class="reservation-form"
                                                    action="{{ route('reservations.update', $reservation->id) }}">
                                                    @csrf
                                                    <input type="date" name="date"
                                                        id="date-{{ $reservation->id }}" class="block text-black"
                                                        value="{{ $reservation->date }}">
                                                    <select name="time" id="time-{{ $reservation->id }}"
                                                        class="block text-black">
                                                        @for ($hour = 8; $hour < 21; $hour++)
                                                            @for ($minute = 0; $minute < 60; $minute += 30)
                                                                @php
                                                                    $formattedHour = str_pad(
                                                                        $hour,
                                                                        2,
                                                                        '0',
                                                                        STR_PAD_LEFT,
                                                                    );
                                                                    $formattedMinute = str_pad(
                                                                        $minute,
                                                                        2,
                                                                        '0',
                                                                        STR_PAD_LEFT,
                                                                    );
                                                                    $time = "{$formattedHour}:{$formattedMinute}";
                                                                @endphp
                                                                <option value="{{ $time }}"
                                                                    @if ($time == $reservation->time) selected @endif>
                                                                    {{ $time }}
                                                                </option>
                                                            @endfor
                                                        @endfor
                                                    </select>
                                                    <select name="number" id="number-{{ $reservation->id }}"
                                                        class="block text-black">
                                                        @for ($number = 1; $number <= 6; $number++)
                                                            <option
                                                                value="{{ $number }}"@if ($number == $reservation->number) selected @endif>
                                                                {{ $number }}人
                                                            </option>
                                                        @endfor
                                                    </select>
                                            </div>
                                            <button id="save-button-{{ $index + 1 }}"
                                                class="mb-4 cursor-pointer fa-sharp fa-light fa-down-to-bracket fa-xl save-button"
                                                type="submit" data-reservation-id="{{ $reservation->id }}"></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="flex items-end justify-between readonly-section">
                                        <div id="readonly-section" class="p-3 rounded-md">
                                            <p class="mb-1">Shop: {{ $reservation->restaurant->name }}</p>
                                            <p id="display-date" class="mb-1">Date: {{ $reservation->date }}</p>
                                            <p id="display-time" class="mb-1">Time: {{ $reservation->time }}</p>
                                            <p id="display-number">Number: {{ $reservation->number }}人</p>
                                        </div>
                                        <div>
                                            {{-- @if (\Carbon\Carbon::now()->format('Y-m-d') == $reservation->date) --}}
                                                <a href="{{ route('reservations.qrcode', ['reservationId' => $reservation->id])}}" class="mr-4 fa-sharp fa-regular fa-qrcode fa-xl"></a>
                                            {{-- @endif --}}
                                            <i id="edit-button-{{ $index + 1 }}"
                                                class="mb-4 mr-1.5 cursor-pointer fa-light fa-pen-to-square fa-xl edit-button"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @if ($reservation->trashed())
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="flex items-center restore"
                                        data-reservation-id="{{ $reservation->id }}">
                                        <i class="mr-4 cursor-pointer fa-duotone fa-hammer fa-xl"></i>
                                        <p class="text-2xl font-bold text-center text-black cursor-pointer">Restore</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-1/12"></div>
            {{-- お気に入りセクション --}}
            <div class="w-full p-4 -mt-[4.5rem] md:w-6/12">
                @php
                    $user = Auth::user();
                @endphp
                <h2 class="mb-8 text-4xl font-bold">{{ $user->name }}さん</h2>
                <h3 class="mb-4 text-xl font-bold">お気に入り店舗</h3>
                @if ($favorites->isEmpty())
                    <p>お気に入りがありません</p>
                @else
                    <div class="grid gap-12 grid-dols-1 sm:grid-cols-2 md:grid-cols-1 lg:grid-cols-2">
                        @foreach ($favorites as $favorite)
                            @php
                                $restaurant = $favorite->restaurant;
                            @endphp
                            <div
                                class="overflow-hidden transition-shadow duration-300 ease-in-out bg-white rounded-lg shadow-md hover:shadow-lg">
                                <img class="object-cover w-full h-40" src="{{ $restaurant->image_url }}"
                                    alt="店舗の写真">
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
                                            <button type="submit" class="text-xl favorite-button"
                                                data-restaurant="{{ $restaurant->id }}"
                                                data-favorited="{{ $favorite->where('restaurant_id', $restaurant->id)->exists() ? 'true' : 'false' }}"
                                                data-favorite-url="{{ route('favorite.store', $restaurant->id) }}"
                                                data-unfavorite-url="{{ route('favorite.destroy', $restaurant->id) }}">
                                                <i
                                                    class="fa-sharp fa-solid fa-heart fa-2xl mt-8 {{ $user->favorites()->where('restaurant_id', $restaurant->id)->exists()? 'icon-red': 'icon-grey' }}">
                                                </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        // SessionScript
        // メッセージ要素の取得
        const messageOverlay = document.getElementById('message-overlay');
        const messageContent = document.getElementById('message-content');
        const okButton = document.getElementById('ok-button');

        // メッセージを表示する関数
        function showMessage(message) {
            messageContent.textContent = message;
            messageOverlay.classList.remove('hidden');
        }

        // OKボタンのクリックイベントリスナー
        okButton.addEventListener('click', function() {
            // メッセージを非表示にする
            hideMessage();
        });

        // メッセージを非表示にする関数
        function hideMessage() {
            messageOverlay.classList.add('hidden');
        }

        // 初期化時にセッションメッセージを表示する
        const sessionMessage = @json($sessionMessage);
        if (sessionMessage) {
            showMessage(sessionMessage);
        }
    </script>
</x-header-app>

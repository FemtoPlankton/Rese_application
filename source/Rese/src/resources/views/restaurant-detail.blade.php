<x-header-app>
    <div class="container px-8 mx-auto mt-8">
        <div class="lg:grid lg:grid-cols-11 lg:gap-1">
            <!-- 店の詳細カラム -->
            <div class="lg:col-span-5">

                <!-- 店名 -->
                <div class="flex items-center my-4">
                    <div onclick="window.history.back()"
                        class="px-3 py-1 mr-4 -mt-2 bg-white rounded-md cursor-pointer shadow-rb-md">
                        <i class="fa-sharp fa-solid fa-angle-left"></i>
                    </div>
                    <h1 class="flex items-center mb-2 text-3xl font-semibold">{{ $restaurant->name }}</h1>
                </div>
                <!-- 店のイメージ -->
                <img src="{{ $restaurant->image_url }}" alt="Shop Image" class="object-cover w-full mb-6 h-[24rem]">

                <!-- エリアとジャンル -->
                <div class="mb-4 text-sm font-medium">
                    <span>#{{ $restaurant->area->name }}</span>
                    <span>#{{ $restaurant->genre->name }}</span>
                </div>

                <!-- 店舗説明 -->
                <p class="leading-relaxed text-gray-600">{{ $restaurant->description }}</p>
            </div>

            <div></div>

            <!-- 予約カラム -->
            <div class="mt-12 mb-12 lg:col-span-5 lg:-mt-20">
                <form id="reservation-form" action="{{ route('reservations.store') }}" method="POST" >
                    @csrf
                    <div class="p-6 bg-blue-600 rounded-t-lg shadow-lg h-[40rem]">

                        <input type="hidden" id="restaurant_id" name="restaurant_id" value="{{ $restaurant->id }}">

                        <h2 class="mb-6 text-2xl font-semibold text-white">予約</h2>

                        <!-- 予約日設定 -->
                        <div class="w-full mb-4">
                            <input type="date" id="date" name="date"
                                class="w-56 rounded-md shadow-sm formform-input">
                        </div>

                        <!-- 予約時間設定 -->
                        <div class="mb-4">
                            <select id="time" name="time" class="w-full rounded-md shadow-sm form-input">
                                @for ($hour = 8; $hour < 21; $hour++)
                                    @for ($minute = 0; $minute < 60; $minute += 30)
                                        @php
                                            $formattedHour = str_pad($hour, 2, '0', STR_PAD_LEFT);
                                            $formattedMinute = str_pad($minute, 2, '0', STR_PAD_LEFT);
                                            $time = "{$formattedHour}:{$formattedMinute}";
                                        @endphp
                                        <option value="{{ $time }}"
                                            @if ($time == '18:00') selected @endif>{{ $time }}
                                        </option>
                                    @endfor
                                @endfor
                            </select>
                        </div>

                        <!-- 人数設定 -->
                        <div class="mb-6">
                            <select id="number" name="number" class="w-full rounded-md shadow-sm form-select">
                                @for ($number = 1; $number <= 6; $number++)
                                    <option value="{{ $number }}" >{{ $number }}人</option>
                                @endfor
                            </select>
                        </div>


                        <div class="flex p-6 text-white bg-blue-500 rounded-md text-md">
                            <div class="mr-8">
                                <p>Shop</p>
                                <p>Data</p>
                                <p>Time</p>
                                <p>Number</p>
                            </div>
                            <div>
                                <p>{{ $restaurant->name }}</p>
                                <p id="selected-date"></p>
                                <p id="selected-time"></p>
                                <p id="selected-number"></p>
                            </div>
                        </div>
                    </div>
                    <!-- 送信ボタン -->
                    <button type="submit"
                        class="w-full py-3 font-bold text-white bg-blue-700 rounded-b-lg shadow-md hover:bg-blue-800">
                        予約する
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-header-app>

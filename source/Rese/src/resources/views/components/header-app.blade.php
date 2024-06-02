<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'laravel') }}</title>
    @vite(['resources/css/icon-color.css', 'resources/css/app.css', 'resources/js/app.js'])
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://kit.fontawesome.com/d2023e62a4.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100 ">

    <header>
        <div class="container px-8 mx-auto mt-8">
            <div class="items-center mt-12">
                <div class="items-center md:grid-cols-10 md:grid md:justify-between">

                    <div class="flex justify-center md:col-span-2 md:justify-start">
                        <div id="menu_button"
                            class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-md cursor-pointer shadow-rb-md">
                            <ion-icon name="menu-outline" size="large" class="icon-color "></ion-icon>
                        </div>
                        <h2 class="flex items-center pl-6 text-4xl font-bold text-blue-600 cursor-default">Rese</h2>
                    </div>

                </div>
            </div>


            <div id="overlay_menu" class="fixed inset-0 z-50 items-center justify-center hidden bg-white">
                <div class="container px-8 mx-auto mt-12">
                    <div class="flex justify-center md:grid-cols-10 md:grid">

                        <div id="close_button"
                            class="flex items-center justify-center w-12 h-12 bg-blue-600 rounded-md cursor-pointer shadow-rb-md">
                            <ion-icon name="close-outline" size="large"></ion-icon>
                        </div>
                        <h2 class="flex items-center pl-6 text-4xl font-bold text-white cursor-default">Rese</h2>

                        <div class="md:col-span-8"></div>
                    </div>
                    <div>
                        @auth
                            <div class="flex flex-col items-center justify-center h-screen -mt-60">
                                <a href="{{ url('/') }}" class="mb-4 text-4xl text-blue-600">Home</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="mb-4 text-4xl text-blue-600">Logout</button>
                                </form>
                                <a href="{{ url('/mypage') }}" class="text-4xl text-blue-600">Mypage</a>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center h-screen -mt-60">
                                <a href="{{ url('/') }}" class="mb-4 text-4xl text-blue-600">Home</a>
                                <a href="{{ url('/register') }}" class="mb-4 text-4xl text-blue-600">Registration</a>
                                <a href="{{ url('/login') }}" class="text-4xl text-blue-600">Login</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

    </header>

    <main>
        {{ $slot }}
    </main>

</body>

</html>

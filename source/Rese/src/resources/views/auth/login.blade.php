<x-header-app>
    <div class="flex items-center justify-center" style="height: calc(100vh - 300px);">
        <form method="POST" action="{{ route('login') }}" class="w-[25rem] bg-white shadow-rb-md rounded-b-md grid ">
            @csrf
            <div class="flex items-center h-12 pl-4 bg-blue-600 rounded-t-md">
                <h2 class="text-white">Login</h2>
            </div>
            <!-- Email Address -->
            <div class="grid grid-cols-12 mt-6">
                <div></div>
                <div class="flex items-center justify-center">
                    <i class="fa-solid fa-envelope fa-xl"></i>
                </div>
                <x-text-input id="email" class="block col-span-9 text-sm" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" placeholder="Email" />
                <div></div>
            </div>

            <div class="grid grid-cols-12">
                <div class="col-span-2"></div>
                <x-input-error :messages="$errors->get('email')" class="col-span-9 mt-2" />
            </div>

            <!-- Password -->
            <div class="grid grid-cols-12">
                <div></div>
                <div class="flex items-center justify-center"">
                    <i class="fa-solid fa-lock-keyhole fa-xl"></i>
                </div>
                <x-text-input id="password" class="block col-span-9 text-sm" type="password" name="password" required
                    autocomplete="current-password" placeholder="Password" />
                <div class="flex items-center -ml-7">
                    <i id="togglePassword" class="fa-solid fa-eye-slash" style="color:#960aa;"></i>
                </div>
            </div>
            <div class="grid grid-cols-12">
                <div class="col-span-2"></div>
                <x-input-error :messages="$errors->get('password')" class="col-span-9 mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="grid grid-cols-12 mt-2">
                <div class="col-span-2"></div>
                <label for="remember_me" class="col-span-9">
                    <input id="remember_me" type="checkbox"
                        class="-mt-1 text-blue-600 border-gray-300 rounded shadow-sm focus:ring-0" name="remember">
                    <span class="text-sm text-gray-600 ms-2">{{ __("ログイン情報を保持する")}}</span>
                </label>
            </div>

            <!-- Session Status -->
            <div class="grid grid-cols-12 mt-2">
                <div class="col-span-2"></div>
                <x-auth-session-status class="col-span-9" :status="session('status')" />
            </div>

            <div class="flex items-center justify-end">
                @if (Route::has('password.request'))
                    <a class="block mt-4 text-xs text-gray-600 underline rounded-md hover:text-gray-900 focus:ring-0"
                        href="{{ route('password.request') }}">
                        {{ __("パスワードをお忘れですか？") }}
                    </a>
                @endif

                <x-primary-button class="col-span-3 mt-8 mb-4 mr-8 text-xl">
                    <p>ログイン</p>
                </x-primary-button>
            </div>
        </form>
    </div>
</x-header-app>

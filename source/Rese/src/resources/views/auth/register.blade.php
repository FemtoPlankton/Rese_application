<x-header-app>
    <div class="flex items-center justify-center" style="height: calc(100vh - 300px);">
        <form method="POST" action="{{ route('register') }}" class="w-[25rem] bg-white shadow-rb-md rounded-b-md grid ">
            @csrf
            <div class="flex items-center h-12 pl-4 bg-blue-600 rounded-t-md">
                <h2 class="text-white">Registration</h2>
            </div>
            <!-- Name -->
            <div class="grid grid-cols-12 mt-6">
                <div></div>
                <div class="flex items-center justify-center">
                    <i class="fa-solid fa-user fa-xl"></i>
                </div>
                <x-text-input id="name" class="block col-span-9 text-sm" type="text" name="name"
                    :value="old('name')" required autofocus autocomplete="name" placeholder="Username" />
                <div></div>
            </div>
            <div class="grid grid-cols-12">
                <div class="col-span-2"></div>
                <x-input-error :messages="$errors->get('name')" class="col-span-9 mt-2" />
            </div>

            <!-- Email Address -->
            <div class="grid grid-cols-12">
                <div></div>
                <div class="flex items-center justify-center">
                    <i class="fa-solid fa-envelope fa-xl"></i>
                </div>
                <x-text-input id="email" class="block col-span-9 text-sm" type="email" name="email"
                    :value="old('email')" required autocomplete="username" placeholder="Email" />
                <div></div>
            </div>
            <div class="grid grid-cols-12">
                <div class="col-span-2"></div>
                <x-input-error :messages="$errors->get('email')" class="col-span-9 mt-2" />
            </div>

            <!-- Password -->
            <div class="grid grid-cols-12">
                <div></div>
                <div class="flex items-center justify-center">
                    <i class="fa-solid fa-lock-keyhole fa-xl"></i>
                </div>
                <x-text-input id="password" class="block col-span-9 text-sm" type="password" name="password" required
                    autocomplete="new-password" placeholder="Password" />
                <div class="flex items-center -ml-7">
                    <i id="togglePassword" class="fa-solid fa-eye-slash" style="color:#960aa;"></i>
                </div>
                <div></div>
            </div>
            <div class="grid grid-cols-12">
                <div class="col-span-2"></div>
                <x-input-error :messages="$errors->get('password')" class="col-span-9 mt-2" />
            </div>

            <div class="flex items-center justify-end">
                <x-primary-button class="mt-8 mb-4 mr-8 text-xl ">
                    <p>登録</p>
                </x-primary-button>
            </div>
        </form>
    </div>
</x-header-app>

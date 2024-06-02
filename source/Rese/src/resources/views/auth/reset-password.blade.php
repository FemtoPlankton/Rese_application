<x-header-app>
    <div class="flex items-center justify-center " style="height: calc(100vh - 300px);">
        <div class="w-[25rem] ">
            <div class="flex items-center h-12 pl-4 bg-blue-600 rounded-t-md">
                <h2 class="text-white">PasswordReset</h2>
            </div>
            <div class="pt-6 bg-white rounded-b-md">
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ request()->route('token') }}">

                    <!-- Email Address -->
                    <div class="grid items-center grid-cols-12">
                        <div></div>
                        <div class="flex items-center justify-center">
                            <i class="fa-solid fa-envelope fa-xl"></i>
                        </div>
                        <div class="col-span-9">
                            <x-text-input id="email" class="w-full text-sm" type="email" name="email"
                                :value="old('email', request()->get('email'))" required autofocus autocomplete="username" placeholder="Email" />
                        </div>
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
                        <div class="col-span-9 ">
                            <x-text-input id="password" class="block w-full mt-1" type="password" name="password"
                                required autocomplete="new-password" placeholder="Password" />
                        </div>
                        <div class="flex items-center -ml-7">
                                <i id="togglePassword" class="fa-solid fa-eye-slash" style="color:#960aa;"></i>
                            </div>

                        <div class="grid grid-cols-12">
                            <div class="col-span-2"></div>
                            <x-input-error :messages="$errors->get('password')" class="col-span-9 mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('Reset Password') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-header-app>

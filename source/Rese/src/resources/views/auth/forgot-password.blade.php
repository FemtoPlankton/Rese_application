<x-header-app>
    <div class="flex items-center justify-center " style="height: calc(100vh - 300px);">
        <div class="w-[25rem] ">
            <div class="flex items-center h-12 pl-4 bg-blue-600 rounded-t-md">
                <h2 class="text-white">ForgotPassword</h2>
            </div>
            <div class="pt-6 bg-white rounded-b-md">
                <div class="grid grid-cols-12 ">
                    <div></div>
                    <div class="col-span-11 mb-4 text-sm text-gray-600">
                        {!! __(
                            'パスワードをお忘れですか？問題ありません。<br>あなたのメールアドレスを入力してください。<br>新しいパスワードを設定できるリンクをお送りします。',
                        ) !!}
                    </div>
                </div>

                <form method="POST" action="{{ route('password.email') }}" class="pb-4">
                    @csrf
                    <!-- Email Address -->
                    <div class="grid items-center grid-cols-12">
                        <div></div>
                        <div>
                            <i class="fa-solid fa-envelope fa-xl"></i>
                        </div>
                        <div class="col-span-9">
                            <x-text-input id="email" class="w-full text-sm" type="email" name="email"
                                :value="old('email')" required autofocus placeholder="Email" />
                        </div>
                    </div>

                    <div class="grid grid-cols-12">
                        <div class="col-span-2"></div>
                        <x-input-error :messages="$errors->get('email')" class="col-span-10 mt-2" />
                    </div>

                    <!-- Session Status -->
                    <div class="grid grid-cols-12">
                        <div class="col-span-2"></div>
                        <x-auth-session-status class="col-span-9 mt-4" :status="session('status')" />
                    </div>

                    <div class="grid grid-cols-12">
                        <div class="col-span-6"></div>
                        <div class="flex items-center justify-end col-span-5 mt-4">
                            <x-primary-button>
                                {{ __('パスワードリセット') }}
                            </x-primary-button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    </div>
</x-header-app>

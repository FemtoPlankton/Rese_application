<x-header-app>
    <div class="flex items-center justify-center " style="height: calc(100vh - 300px);">
        <div class="w-[25rem] ">
            <div class="flex items-center h-12 pl-4 bg-blue-600 rounded-t-md">
                <h2 class="text-white">Error</h2>
            </div>
            <div class="pt-6 bg-white rounded-md">
                <div class="grid grid-cols-12">
                    <div></div>
                    <div class="col-span-10 text-gray-600">
                        <ul class="flex justify-center mb-12">
                            {{-- @if (session('message'))
                                <h2 class="m-auto">{{ session('message') }}</h2>
                            @else
                                <h2 class="m-auto">Error</h2>
                            @endif --}}
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="flex justify-center">
                    <x-primary-button id="index-button"
                        class="justify-center text-xl max-w-[7.5rem] m-auto -mt-0 mb-8">戻る</x-primary-button>
                </div>
            </div>
        </div>
    </div>
</x-header-app>

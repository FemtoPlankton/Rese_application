<x-header-app>
    <div class="flex items-center justify-center " style="height: calc(100vh - 300px);">
        <div class="w-[30rem] h-[18rem] bg-white rounded-md shadow-rb-md grid items-center justify-center">
            @if (session('message'))
                <h2 class="m-auto mt-20 text-2xl">{{ session('message') }}</h2>
            @else
                <h2 class="m-auto mt-20 text-2xl">Error</h2>
            @endif
            <x-primary-button id="index-button" class="justify-center text-xl max-w-[7.5rem] m-auto -mt-0">戻る</x-primary-button>
        </div>
    </div>
</x-header-app>

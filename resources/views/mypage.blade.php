<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('MyPage') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="class="p-6 text-gray-900 dark:text-gray-100">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

         {{-- 目標の一覧を表示 --}}
        <div class="mt-8 flex items-center flex-col">
            <h1 class="mb-4 text-4xl font-bold text-gray-800 dark:text-gray-200">目標一覧</h1>
            <p class="mb-4 text-lg text-gray-600 dark:text-gray-400">
                ここに目標の一覧を表示します。
            </p>
        </div>

    </div>
</x-app-layout>
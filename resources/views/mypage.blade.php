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
            <div class="mb-4 text-lg text-gray-600 dark:text-gray-400 w-full max-w-4xl">
                @foreach ($goals as $goal)
                    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg mb-4 p-4">
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                            <a href="{{ route('goal.show', $goal->id) }}">{{ $goal->title }}</a>
                        </h2>
                        <div class="text-gray-600 dark:text-gray-400">
                            <span>進捗度：{{ $goal->progress }}%</span>
                            <span>達成期限：{{ $goal->deadline }}</span>
                            <span>{{ $goal->is_completed ? '達成済み' : '未達成' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
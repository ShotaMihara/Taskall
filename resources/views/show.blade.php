<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ゴール詳細画面') }}
        </h2>
    </x-slot>

    {{-- 目標の詳細を表示 --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200 mb-4">ゴール詳細</h1>
                    <div class="mb-4 text-lg text-gray-600 dark:text-gray-400">
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ $goal->title }}</h2>
                        <div class="mt-2">
                            <span class="block">進捗度：{{ $goal->progress }}%</span>
                            <span class="block">達成期限：{{ $goal->deadline }}</span>
                            <span class="block">{{ $goal->is_completed ? '達成済み' : '未達成' }}</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">タスク一覧</h3>
                            <ul class="list-disc list-inside">
                                @foreach ($tasks as $task)
                                    <li>{{ $task->name }} 締切: {{ $task->deadline }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">リソース一覧</h3>
                            <ul class="list-disc list-inside mt-2">
                                @foreach ($resources as $resource)
                                        <li><a href="{{ $resource->link }}" class="text-blue-500 hover:underline">{{ $resource->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mt-4 flex space-x-2">
                            <a href="" class="inline-block px-5 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">編集</a>
                            <form action="" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-block px-5 py-2 bg-red-500 text-white rounded hover:bg-red-600">削除</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
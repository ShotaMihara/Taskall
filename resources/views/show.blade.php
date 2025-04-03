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
                        
                        <!-- 進捗度の表示 -->
                        <div class="mt-4">
                            <p class="text-lg font-medium">
                                進捗度: <span class="text-blue-500">{{ $progress }}%</span>
                            </p>
                            <div class="w-full bg-gray-300 rounded-full h-4 mt-2">
                                <div class="bg-blue-500 h-4 rounded-full" style="width: {{ $progress }}%;"></div>
                            </div>
                        </div>

                        <!-- タスク一覧 -->
                        <div class="mt-4">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">タスク一覧</h3>
                            <ul class="list-disc list-inside mt-4">
                                @foreach ($tasks as $task)
                                    <li>
                                        {{ $task->name }}
                                        <a href="{{ route('tasks.edit', $task->id) }}" class="ml-2 text-blue-500 hover:underline">編集</a>
                                        <form action="{{ route('tasks.toggleStatus', $task->id) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            @method('PATCH')
                                            @if ($task->status)
                                                <button type="submit" class="text-green-500 hover:underline">完了</button>
                                            @else
                                                <button type="submit" class="text-red-500 hover:underline">未完了</button>
                                            @endif
                                        </form>
                                    </li>
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
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
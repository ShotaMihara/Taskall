<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ゴール詳細画面') }}
        </h2>
    </x-slot>

    

         {{-- 目標の一覧を表示 --}}
         <div class="mt-8 flex items-center flex-col">
            <h1 class="mb-4 mt-4 text-4xl font-bold text-gray-800 dark:text-gray-200">ゴール詳細</h1>
            <div class="mb-4 text-lg text-gray-600 dark:text-gray-400 w-full max-w-4xl">
                <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg mb-4 p-4">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ $goal->title }}</h2>
                    <div class="text-gray-600 dark:text-gray-400">
                        <span>進捗度：{{ $goal->progress }}%</span>
                        <span>達成期限：{{ $goal->deadline }}</span>
                        <span>{{ $goal->is_completed ? '達成済み' : '未達成' }}</span>
                        <div class="mt-4">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">タスク一覧</h3>
                            <ul class="list-disc list-inside">
                                @foreach ($tasks as $task)
                                    <li>{{ $task->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            編集
                        </a>
                        <form action="" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                削除
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
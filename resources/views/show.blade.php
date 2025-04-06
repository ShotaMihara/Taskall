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
                                進捗度: <span class="text-blue-500">{{ $goal->progress }}%</span>
                            </p>
                            <div class="w-full bg-gray-300 rounded-full h-4 mt-2">
                                <div class="bg-blue-500 h-4 rounded-full" style="width: {{ $goal->progress }}%;"></div>
                            </div>
                        </div>

                        <!-- タスク一覧 -->
                        <div class="flex flex-col gap-4 mt-4">
                            @foreach ($tasks as $task)
                                <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg p-4 border border-transparent hover:border-gray-300">
                                    <div class="flex justify-between items-center">
                                        <!-- チェックボックスとタスク名 -->
                                        <div class="flex">
                                            <form action="{{ route('tasks.toggleStatus', $task->id) }}" method="POST" id="toggle-form-{{ $task->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="color-mode" id="color-mode-{{ $task->id }}">
                                                <input 
                                                    type="checkbox" 
                                                    onchange="submitToggleForm({{ $task->id }})" 
                                                    {{ $task->status ? 'checked' : '' }} 
                                                    class="mr-2 w-5 h-5 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                                                >
                                            </form>
                                            <div>
                                                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                                    {{ $loop->iteration }}. {{ $task->name }}
                                                </h2>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                    <p class="list-disc pl-5">
                                                        @foreach (explode(' ', $task->description) as $description)
                                                            <p>{{ $description }}</p>
                                                        @endforeach
                                                    </p>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- 編集リンク -->
                                        <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-500 hover:underline">編集</a>
                                    </div>
                                </div>
                            @endforeach
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

<script>
    function submitToggleForm(taskId) {
        // localStorage から color-mode を取得して隠しフィールドに設定
        const colorMode = localStorage.getItem('color-mode');
        document.getElementById(`color-mode-${taskId}`).value = colorMode;

        // フォームを送信
        document.getElementById(`toggle-form-${taskId}`).submit();
    }

    // ページ読み込み時に color-mode を適用
    const colorMode = localStorage.getItem('color-mode');
    if (colorMode === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>
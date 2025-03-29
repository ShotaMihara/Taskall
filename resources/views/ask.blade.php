<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('タスク確認ページ') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <h1 class="text-2xl font-bold mb-4">Geminiの回答</h1>

                    <h3 class="text-lg font-semibold mb-2">目標に対してタスクを作成してください:</h3>
                    <ul class="list-disc pl-5">
                        @foreach ($Tasknames as $name)
                            <li>{{ $name }}</li>
                        @endforeach
                    </ul>

                    <h3 class="text-lg font-semibold mb-2">作成されたタスクの詳細:</h3>
                    <ul class="list-disc pl-5">
                        @foreach ($Taskdescription as $description)
                            <li>{{ $description }}</li>
                        @endforeach

                    <h3 class="text-lg font-semibold mb-2">作成されたタスクに有効なURLを表示してください:</h3>
                    <ul class="list-disc pl-5">
                        @foreach ($Taskurl as $url)
                            <li>{{ $url }}</li>
                        @endforeach
                    </ul>

                    <a href="/setting" class="inline-block mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
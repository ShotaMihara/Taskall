<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('タスク確認ページ') }}
        </h2>
    </x-slot>
    <div class="flex mt-8 h-screen">
        <!-- 左側のコンテンツ部分 -->
        <div class="w-3/4 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-6 rounded-lg shadow-lg border-b-4 border-gray-800 overflow-y-auto custom-scrollbar">
            <h1 class="text-2xl font-bold mb-4 flex items-center justify-center">作成されたタスク</h1>
            <div class="mb-4 text-lg">
                @foreach ($Tasknames as $index => $name)
                    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg mb-4 p-4 border border-transparent hover:border-white">
                        <!-- タスク名 -->
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                            <ul class="list-disc pl-5">
                                <li>{{ $name }}</li>
                            </ul>
                        </h2>

                        <!-- タスクの説明 -->
                        <div class="text-gray-600 dark:text-gray-400 p-2">
                            <h3 class="text-lg font-bold mt-4">タスクの詳細</h3>
                            <ul class="list-disc pl-5">
                                @foreach (array_chunk($Taskdescription, 3)[$index] ?? [] as $description)
                                    <li>{{ $description }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- 区切り線 -->
                    @if (!$loop->last)
                        <hr class="border-t border-gray-300 dark:border-gray-600 my-4">
                    @endif
                @endforeach
            </div>
        </div>

        <!-- 右側のコンテンツ部分 -->
        <div class="w-1/4 bg-gray-800 dark:bg-gray-900 text-white p-6 rounded-lg shadow-lg overflow-y-auto custom-scrollbar">
            <h1 class="text-2xl font-bold mb-4">関連動画</h1>
            <div class="grid grid-cols-1 gap-4">
                @foreach ($TaskVideo as $video)
                    <div class="bg-gray-700 rounded-lg shadow-md overflow-hidden">
                        <a href="{{ $video['url'] }}" target="_blank" class="block">
                            <img src="https://img.youtube.com/vi/{{ explode('=', $video['url'])[1] }}/hqdefault.jpg" alt="{{ $video['title'] }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-white">
                                    {{ $video['title'] }}
                                </h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('タスク確認ページ') }}
        </h2>
    </x-slot>
    <div class="flex flex-col mt-8 h-screen">
        <!-- ボタン部分 -->
        
        <div class="flex justify-center items-center gap-4 mb-4 px-6">
            <form action="{{ route('save.to.database') }}" method="POST">
                @csrf
                <input type="hidden" name="prompt" value="{{ request('question') }}">
                <input type="hidden" name="taskNames" value="{{ json_encode($taskNames) }}">
                <input type="hidden" name="taskDescriptions" value="{{ json_encode($taskDescriptions) }}">
                <input type="hidden" name="taskVideos" value="{{ json_encode($taskVideos) }}">
                <button type="submit" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#f9f8f54a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    タスクを保存
                </button>
            </form>
            <!-- 再読み込みボタン -->
            <button onclick="startLoading()" 
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#f9f8f54a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                再読み込み
            </button>
            <!-- 再度目標を設定ボタン -->
            <a href="/setting" 
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#f9f8f54a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                再度目標を設定
            </a>
        </div>
        

        <div class="flex h-full">
            <!-- 左側のコンテンツ部分 -->
            <div id="leftContent" class="w-3/4 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-6 mx-6 rounded-lg shadow-lg border-b-4 border-gray-800 overflow-y-auto custom-scrollbar">
                <h1 class="text-2xl font-bold mb-4 flex items-center justify-center">作成されたタスク</h1>
                <div class="mb-4 text-lg">
                    @foreach ($taskNames as $index => $name)
                        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg mb-4 p-4 border border-transparent hover:border-white">
                            <!-- タスク名 -->
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                                <ol class="list-disc pl-5">
                                    <ol>{{ $loop->iteration }}. {{ $name }}</ol>
                                </ol>
                            </h2>

                            <!-- タスクの説明 -->
                            <div class="text-gray-600 dark:text-gray-400 p-2">
                                <h3 class="text-lg font-bold mt-2 mb-2">タスクの詳細</h3>
                                <ul class="list-disc pl-5">
                                    @foreach (array_chunk($taskDescriptions, 3)[$index] ?? [] as $description)
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
            <div class="w-1/4 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-6 rounded-lg shadow-lg overflow-y-auto custom-scrollbar">
                <h1 class="text-2xl font-bold mb-4">関連動画</h1>
                <div class="grid grid-cols-1 gap-4">
                    @if (!empty($taskVideos))
                        @foreach ($taskVideos as $video)
                            <div class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg shadow-md overflow-hidden">
                                <a href="{{ $video['url'] }}" target="_blank" class="block">
                                    <img src="https://img.youtube.com/vi/{{ explode('=', $video['url'])[1] }}/hqdefault.jpg" alt="{{ $video['title'] }}" class="w-full h-48 object-cover">
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                            {{ $video['title'] }}
                                        </h3>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <p>関連動画が見つかりません。</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="loadingSpinner" class="hidden flex flex-col items-center justify-center h-full">
        <svg class="animate-spin h-10 w-10 text-gray-600 dark:text-gray-300 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <p class="text-lg text-gray-600 dark:text-gray-300" aria-live="polite">タスク作成中...</p>
    </div>

    <script>
        function startLoading() {
            const leftContent = document.getElementById('leftContent');

            // 左側のコンテンツをローディング状態に変更
            leftContent.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full">
                    <svg class="animate-spin h-10 w-10 text-gray-600 dark:text-gray-300 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <p class="text-lg text-gray-600 dark:text-gray-300" aria-live="polite">タスク作成中...</p>
                </div>
            `;

            // ページをリロード
            setTimeout(() => {
                location.reload();
            }, 2000); // 2秒後にリロード
        }
    </script>
</x-app-layout>
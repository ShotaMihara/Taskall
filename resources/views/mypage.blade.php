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
                        {{ session('success') }}
                    </div>
                </div>
            @endif
        </div>

        {{-- 目標の一覧を表示 --}}
        <div class="mt-8 flex items-center flex-col">
            <h1 class="mb-4 text-4xl font-bold text-gray-800 dark:text-gray-200">目標一覧</h1>
            <div class="mb-4 text-lg text-gray-600 dark:text-gray-400 w-full max-w-4xl">
                @foreach ($goals as $goal)
                    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg mb-4 p-4 border border-transparent hover:border-white">
                        <h2 class="mt-2 text-2xl font-semibold text-gray-800 dark:text-gray-200">
                            {{ $goal->title }}
                        </h2>
                        <div class="text-gray-600 dark:text-gray-400">
                            <div class="mt-4">
                                <p class="text-lg font-medium">
                                    進捗度: <span class="text-blue-500">{{ $goal->progress }}%</span>
                                </p>
                                <div class="w-full bg-gray-300 rounded-full h-4 mt-2">
                                    <div class="bg-blue-500 h-4 rounded-full" style="width: {{ $goal->progress }}%;"></div>
                                </div>
                                <p class="mt-2 mb-2">ステータス：{{ $goal->progress == 100 ? '達成済み' : '未達成' }}</ｐ><br>
                                <a href="{{ route('show', $goal->id) }}" class="inline-flex items-center mt-2 px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    詳細を見る
                                </a>
                            </div>
                            
                        </div>
                    </div>
                @endforeach
                @if ($goals->isEmpty())
                    <p class="text-gray-600 text-center dark:text-gray-400">目標が登録されていません。</p>
                @endif
            </div>
            <div class="mb-4">
                <a href="{{ route('setting') }}" class="inline-flex items-center mt-2 px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    ＋目標を追加
                </a>
        </div>
    </div>
</x-app-layout>
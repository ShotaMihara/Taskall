<x-guest-layout>

    <!-- アプリの概要説明 -->
    <div class="mt-8 flex items-center flex-col">
        <h1 class="mb-4 text-4xl font-bold text-blue-600">Taskall</h1>
        <p class="mb-4 text-lg text-center text-gray-600 dark:text-gray-400">
            目標を入力するだけで、
            <br>
            やることが明確に。
        </p>
    </div>
    <div>
    @if (Route::has('login'))
        <nav class="flex items-center justify-center gap-4">
            @auth
                <a
                    href="{{ url('/mypage') }}"
                    class="inline-flex items-center mt-2 px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    My Pageへ
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="inline-flex items-center mt-2 px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    ログイン
                </a>
    
                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="inline-flex items-center mt-2 px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        新規登録
                    </a>
                @endif
            @endauth
        </nav>
    @endif
    </div>
    </x-guest-layout>
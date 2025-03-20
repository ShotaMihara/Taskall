<x-guest-layout>

    <!-- アプリの概要説明 -->
    <div class="mt-8 flex items-center flex-col">
        <h1 class="mb-4 text-4xl font-bold text-gray-800 dark:text-gray-200">アプリの概要</h1>
        <p class="mb-4 text-lg text-gray-600 dark:text-gray-400">
            アプリの特徴や機能について簡単に説明します。
        </p>
    </div>
    <div>
    @if (Route::has('login'))
        <nav class="flex items-center justify-center gap-4">
            @auth
                <a
                    href="{{ url('/mypage') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    My Pageへ
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                    ログイン
                </a>
    
                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                        新規登録
                    </a>
                @endif
            @endauth
        </nav>
    @endif
    </div>
    </x-guest-layout>
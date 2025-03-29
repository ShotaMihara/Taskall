<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('目標設定ページ') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col items-center">
                    <h1 class="text-lg font-semibold mb-4 text-center">目標を入力してください</h1>
                    <form action="/ask" method="GET" class="w-full max-w-md flex flex-col items-center">
                        <label for="question" class="block text-sm font-medium mb-2 text-center">例）電気工事士になりたい、簿記資格を取得したい</label>
                        <input type="text" id="question" name="question" required
                            class="mt-1 mb-4 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 bg-white dark:text-gray-100 dark:bg-gray-700">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            送信
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

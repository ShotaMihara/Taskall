<!-- filepath: /Users/user/Taskall/resources/views/tasks/edit.blade.php -->
<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">タスク編集</h1>
            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">タスク名</label>
                    <input type="text" name="name" id="name" value="{{ $task->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">タスク詳細</label>
                    <input type="text" name="name" id="name" value="{{ $task->description }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300">締切</label>
                    <input type="date" name="deadline" id="deadline" value="{{ $task->deadline }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">保存</button>
            </form>
        </div>
    </div>
</x-app-layout>
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * タスク編集ページを表示
     */
    public function edit(Task $task)
    {
        return view('task_edit', compact('task'));
    }

    /**
     * タスクを更新
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'deadline' => 'nullable|date',
        ]);

        $task->updateTask($validated);

        // ゴール詳細ページへリダイレクト
        return redirect()->route('show', ['id' => $task->goal_id])->with('success', 'タスクが更新されました！');
    }

    /**
     * タスクを削除
     */
    public function destroy(Task $task)
    {
        $task->deleteTask();

        return redirect()->route('show', ['id' => $task->goal_id])->with('success', 'タスクが削除されました！');
    }

    /**
     * タスクの状態を切り替え
     */
    public function toggleStatus(Request $request, Task $task)
    {
        $task->toggleStatus();

        // color-mode をセッションに保存
        if ($request->has('color-mode')) {
            session(['color-mode' => $request->input('color-mode')]);
        }

        return redirect()->back();
    }
}

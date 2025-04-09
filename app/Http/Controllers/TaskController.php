<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\UpdateTaskRequest;
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
    public function update(UpdateTaskRequest $request, Task $task)
    {
        // バリデーション済みデータを取得
        $validated = $request->validated();

        // タスクを更新
        $task->updateTask($validated);

        // ゴール詳細ページへリダイレクト
        return redirect()->route('show', ['id' => $task->goal_id])->with('success', 'タスクが更新されました！');
    }

    /**
     * タスクを削除
     */
    public function destroy(Task $task)
    {
        // タスクを削除
        $task->deleteTask();
        // ゴール詳細ページへリダイレクト
        return redirect()->route('show', ['id' => $task->goal_id])->with('success', 'タスクが削除されました！');
    }

    /**
     * タスクの状態を切り替え
     */
    public function toggleStatus(Request $request, Task $task)
    {
        // タスクの状態を切り替え
        $task->toggleStatus();
        
        if ($request->has('color-mode')) {
            session(['color-mode' => $request->input('color-mode')]);
        }

        return redirect()->back();
    }
}

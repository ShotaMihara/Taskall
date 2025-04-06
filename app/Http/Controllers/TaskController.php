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
            'deadline' => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()->route('mypage')->with('success', 'タスクが更新されました！');
    }

    /**
     * タスクの状態を切り替え
     */
    public function toggleStatus(Request $request, Task $task)
    {
        // タスクのステータスを切り替える
        $task->status = !$task->status;
        $task->save();

        // color-mode をセッションに保存
        if ($request->has('color-mode')) {
            session(['color-mode' => $request->input('color-mode')]);
        }

        return redirect()->back();
    }
}

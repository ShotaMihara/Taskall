<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;

class GoalController extends Controller
{
    public function GoalIndex()
    {
        $goals = Goal::where('user_id', auth()->id())->with('tasks')->get();

        // 各ゴールの進捗度を計算
        $goals->each(function ($goal) {
            $goal->calculateProgress();
        });

        return view('mypage', compact('goals'));
    }

    public function GoalShow($id)
    {
        $goal = Goal::with('resources', 'tasks')->findOrFail($id);

        // タスクとリソースを取得
        $tasks = $goal->tasks;
        $resources = $goal->resources;

        // 進捗度を計算
        $goal->calculateProgress();

        return view('show', compact('goal', 'tasks', 'resources'));
    }

    public function destroy($id)
    {
        // ゴールを取得
        $goal = Goal::findOrFail($id);

        // ゴールを削除
        $goal->delete();

        // マイページにリダイレクト
        return redirect()->route('mypage')->with('success', 'ゴールが削除されました！');
    }
}


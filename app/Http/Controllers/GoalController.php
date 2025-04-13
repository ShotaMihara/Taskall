<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;

class GoalController extends Controller
{
    public function GoalIndex()
    {
        // ユーザーのゴールを取得
        $goals = Goal::forUser(auth()->id());
        return view('mypage', compact('goals'));
    }
    
    public function GoalShow($id)
    {
        // ゴールの詳細を取得
        $goal = Goal::withDetails($id);
        return view('show', [
            'goal' => $goal,
            'tasks' => $goal->tasks,
            'resources' => $goal->resources,
        ]);
    }

    public function goalDestroy($id)
    {
        // ゴールを削除
        Goal::deleteById($id);
        return redirect()->route('mypage')->with('success', 'ゴールが削除されました！');
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;

class GoalController extends Controller
{
    public function GoalIndex()
    {
        $goals = Goal::forUser(auth()->id());
        return view('mypage', compact('goals'));
    }
    
    public function GoalShow($id)
    {
        $goal = Goal::withDetails($id);
        return view('show', [
            'goal' => $goal,
            'tasks' => $goal->tasks,
            'resources' => $goal->resources,
        ]);
    }

    public function goalDestroy($id)
    {
        Goal::deleteById($id);
        return redirect()->route('mypage')->with('success', 'ゴールが削除されました！');
    }
}


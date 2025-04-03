<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;

class GoalController extends Controller
{
    public function GoalIndex()
    {
        $goals = Goal::where('user_id', auth()->id())->get();
        return view('mypage', compact('goals'));
    }

    public function GoalShow($id)
    {
        $goal = Goal::with('resources', 'tasks')->findOrFail($id);
        $tasks = $goal->tasks;
        $resources = $goal->resources;

        // タスク全体の進捗度を計算
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 1)->count();
        $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

        return view('show', compact('goal', 'tasks', 'resources', 'progress'));
    }
}


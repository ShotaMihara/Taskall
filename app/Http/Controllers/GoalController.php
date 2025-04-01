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
        $goal = Goal::with('resources','tasks')->findOrFail($id);
        $tasks = $goal->tasks;
        $resources = $goal->resources;
        

        return view('show', compact('goal', 'tasks', 'resources'));
    }
}


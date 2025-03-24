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
        $goal = Goal::find($id);
        $tasks = $goal->tasks;
        $resources = $goal->resources->map(function ($resource) {
            $resource->title = $resource->fetchTitle();
            return $resource;
        });

        return view('show', compact('goal', 'tasks', 'resources'));
    }
}

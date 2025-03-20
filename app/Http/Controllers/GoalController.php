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

    
}

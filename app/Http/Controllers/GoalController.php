<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoalService;

class GoalController extends Controller
{
    protected $goalService;

    public function __construct(GoalService $goalService)
    {
        $this->goalService = $goalService;
    }

    public function index()
    {
        $goals = $this->goalService->getGoalsForUser(auth()->id());
        return view('mypage', compact('goals'));
    }

    public function show($id)
    {
        $goal = $this->goalService->getGoalWithDetails($id);
        return view('show', [
            'goal' => $goal,
            'tasks' => $goal->tasks,
            'resources' => $goal->resources,
        ]);
    }

    public function destroy($id)
    {
        $this->goalService->deleteGoalById($id);
        return redirect()->route('mypage')->with('success', 'ゴールが削除されました！');
    }
}


<?php

namespace App\Services;

use App\Models\Goal;

class GoalService
{
    /**
     * 指定されたユーザーのゴールを取得し、進捗度を計算
     */
    public function getGoalsForUser($userId)
    {
        $goals = Goal::where('user_id', $userId)->with('tasks')->get();
        $goals->each(function ($goal) {
            $this->calculateProgress($goal);
        });
        return $goals;
    }

    /**
     * ゴールの詳細を取得し、進捗度を計算
     */
    public function getGoalWithDetails($id)
    {
        $goal = Goal::with('resources', 'tasks')->findOrFail($id);
        $this->calculateProgress($goal);
        return $goal;
    }

    /**
     * ゴールを削除
     */
    public function deleteGoalById($id)
    {
        $goal = Goal::findOrFail($id);
        $goal->delete();
    }

    /**
     * ゴールの進捗度を計算
     */
    public function calculateProgress(Goal $goal)
    {
        $totalTasks = $goal->tasks->count();
        $completedTasks = $goal->tasks->where('status', 1)->count();
        $goal->progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;
        $goal->save();
    }
}
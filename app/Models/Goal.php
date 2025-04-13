<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'deadline',
        'progress',
        'is_completed',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * 進捗度を計算して保存
     */
    public function calculateProgress()
    {
        // ゴールに関連するタスクをカウント
        $totalTasks = $this->tasks->count();
        // 完了したタスクをカウント
        $completedTasks = $this->tasks->where('status', 1)->count();
        // タスクがあれば、完了したタスクの割合を計算
        $this->progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;
        // progressを更新
        $this->save();
    }

    public static function forUser($userId)
    {
        // ユーザーに関連するゴールを取得
        $goals = self::where('user_id', $userId)->with('tasks')->get();
        // 各ゴールの進捗度を計算
        $goals->each(function ($goal) {
            $goal->calculateProgress();
        });
        return $goals;
    }

    public static function withDetails($id)
    {
        // ゴールの詳細を取得
        $goal = self::with('resources', 'tasks')->findOrFail($id);
        // タスクの進捗度を計算
        $goal->calculateProgress();
        return $goal;
    }

    public static function deleteById($id)
    {
        // ゴールを削除
        $goal = self::findOrFail($id);
        $goal->delete();
    }

}

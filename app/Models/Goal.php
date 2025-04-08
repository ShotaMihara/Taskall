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
        $totalTasks = $this->tasks->count();
        $completedTasks = $this->tasks->where('status', 1)->count();
        $this->progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;
        $this->save();
    }

    public static function forUser($userId)
    {
        $goals = self::where('user_id', $userId)->with('tasks')->get();
        $goals->each(function ($goal) {
            $goal->calculateProgress();
        });
        return $goals;
    }

    public static function withDetails($id)
    {
        $goal = self::with('resources', 'tasks')->findOrFail($id);
        $goal->calculateProgress();
        return $goal;
    }

    public static function deleteById($id)
    {
        $goal = self::findOrFail($id);
        $goal->delete();
    }

}

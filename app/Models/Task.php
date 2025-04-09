<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'name',
        'description',
        'deadline',
        'status',
        'order',
    ];

    /**
     * ゴールとのリレーション
     */
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    /**
     * タスクを更新
     */
    public function updateTask(array $data)
    {
        $this->update($data);
    }

    /**
     * タスクを削除
     */
    public function deleteTask()
    {
        $this->delete();
    }

    /**
     * タスクの状態を切り替え
     */
    public function toggleStatus()
    {
        $this->status = !$this->status;
        $this->save();
    }
}

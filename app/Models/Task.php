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

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}

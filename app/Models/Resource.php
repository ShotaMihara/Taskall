<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Resource extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'goal_id',
        'link',
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}

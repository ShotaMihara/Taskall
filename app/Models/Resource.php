<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'title',
        'link',
    ];

    public function goals()
    {
        return $this->belongsTo(Goal::class);
    }

}

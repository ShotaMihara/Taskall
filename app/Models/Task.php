<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
    
}

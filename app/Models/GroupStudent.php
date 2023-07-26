<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupStudent extends Pivot
{
    protected $fillable = [
        'group_id',
        'student_id'
    ];

    public function group() 
    {
        return $this->belongsTo(Group::class);
    }
}

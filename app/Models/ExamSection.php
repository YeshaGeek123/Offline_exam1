<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ExamSection extends Pivot
{
    public function section() 
    {
        return $this->belongsTo(Section::class);
    }
}

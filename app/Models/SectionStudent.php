<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SectionStudent extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'student_id'
    ];
}

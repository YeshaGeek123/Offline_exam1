<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_section_id',
        'title',
        'ext_group_id'
    ];

    public function section() 
    {
        return $this->belongsTo(ExamSection::class, 'exam_section_id');
    }
}

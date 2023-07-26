<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    // use HasFactory;

    protected $fillable = [
        'ext_section_id',
        'title',
    ];

    public function role() 
    {
        return $this->belongsTo(Role::class);
    }

    public function exams() 
    {
        return $this->belongsToMany(Exam::class);
    }

    public function getExamIds()
    {
        return $this->exams()->allRelatedIds();
    }
}

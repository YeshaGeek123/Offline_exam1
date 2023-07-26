<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_type_id',
        'section_id',
        'procedure_id',
        'category_id',
        'title',
    ];

    public function exam_type() 
    {
        return $this->belongsTo(ExamType::class);
    }

    public function section() 
    {
        return $this->belongsTo(Section::class);
    }

    public function procedure() 
    {
        return $this->belongsTo(Procedure::class);
    }

    public function category() 
    {
        return $this->belongsTo(Category::class);
    }

    public function criterias() 
    {
        return $this->hasMany(Criteria::class);
    }
}
  
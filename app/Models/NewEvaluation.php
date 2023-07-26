<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class NewEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'cubicle_id',
        'user_id',
        'student_id',
        'section_id',
        'procedure_id',
        'status',
        'is_ongoing',
        'confirmation_status',
        'round',
    ];


    protected $appends = ['count_position'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    public function getCountPositionAttribute()
    {
        return NewEvaluation::where('cubicle_id', $this->cubicle_id)->where('student_id', $this->student_id)->where('procedure_id', $this->procedure_id)->where('section_id', $this->section_id)->where('is_ongoing', 1)->count();
    }
}

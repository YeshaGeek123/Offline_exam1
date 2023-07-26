<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'name',
        'email',
        'address',
        'phone',
        'cubicle',
        'submission_cubicle',
        'is_present',
        'is_being_evaluated',
        'is_being_evaluated_by',
        'sequence_number',
        'ext_student_id',
        'social',
        'school',
        'graduation_date',
        'is_terminated',
        'reason',
    ];

    public function exam() 
    {
        return $this->belongsTo(Exam::class);
    }

    public function groups() 
    {
        return $this->belongsToMany(Group::class);
    }

    public function getGroupIdsAttribute() 
    {
        return $this->groups()->allRelatedIds();
    }

    public function sections() 
    {
        return $this->belongsToMany(Section::class);
    }

    public function evaluations() 
    {
        return $this->hasMany(NewEvaluation::class);
    }

    public function checkResult($procedureId) 
    {
        $evaluations = $this->evaluations();

        $latestEvaluation = $evaluations->where('procedure_id', $procedureId)->latest()->first();

        if ( !empty($latestEvaluation) && !$latestEvaluation->is_ongoing && $evaluations->where('procedure_id', $procedureId)->where('round', $latestEvaluation->round)->count() == 3 && !$evaluations->where('procedure_id', $procedureId)->where('round', $latestEvaluation->round)->where('status', 3)->exists() ) return 'P';
        
        return ;
    }
}

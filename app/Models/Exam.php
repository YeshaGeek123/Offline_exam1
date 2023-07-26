<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'code',
        'exam_start',
        'exam_end',
        'publish_status',
        'status',
        'ext_exam_id',
        'type',
        'facility_name',
        'state',
        'zip',
        'address',
    ];

    public function getExamDateTimeCarbonAttribute() 
    {
        return Carbon::parse($this->exam_date_time)->format('Y-m-d\TH:i');
    }

    public function students() 
    {
        return $this->hasMany(Student::class);
    }

    public function cubicles() 
    {
        return $this->hasMany(Cubicle::class);
    }

    public function users() 
    {
        return $this->belongsToMany(User::class);
    }

    public function getUserIds()
    {
        return $this->users()->allRelatedIds();
    }

    public function getCubicleIds()
    {
        return $this->cubicles()->allRelatedIds();
    }

    public function sections() 
    {
        return $this->belongsToMany(Section::class)->withPivot('id');
    }
}

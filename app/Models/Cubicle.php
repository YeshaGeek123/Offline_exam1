<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cubicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'cubicle_number',
        'identifier',
        'has_kindle',
        'need_cleanup',
        'has_failed',
    ];

    public function evaluations() 
    {
        return $this->hasMany(NewEvaluation::class);
    }
    
    public function recent_evaluation() 
    {
        return $this->hasOne(NewEvaluation::class);
    }
}

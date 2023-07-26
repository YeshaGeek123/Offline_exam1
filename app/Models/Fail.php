<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fail extends Model
{
    use HasFactory;

    protected $fillable = [
        'new_evaluation_id',
        'criteria_id',
    ];

    public function criteria() 
    {
        return $this->belongsTo(Criteria::class);
    }

    public function evaluation() 
    {
        return $this->belongsTo(NewEvaluation::class, 'new_evaluation_id');
    }
}

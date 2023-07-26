<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'questionnaire_id',
        'title',
        'is_acceptable',
    ];

    public function fails() 
    {
        return $this->hasMany(Fail::class);
    }

    public function questionnaire() 
    {
        return $this->belongsTo(Questionnaire::class);
    }
}

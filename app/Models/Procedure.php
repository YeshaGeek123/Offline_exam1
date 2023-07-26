<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'ext_procedure_id',
        'title',
    ];

    public function section() 
    {
        //return $this->belongsTo(Section::class, 'section_id');
        return DB::table('procedures')->select('procedures.id', 'procedures.section_id', 'procedures.title', DB::raw('GROUP_CONCAT(sections.title SEPARATOR ", ") AS sec_title'))->join('sections', function ($join) {$join->fromRaw('FIND_IN_SET(sections.id, procedures.section_id)');})->whereRaw('FIND_IN_SET(sections.id, procedures.section_id) > 0')->groupBy('procedures.id', 'procedures.section_id', 'procedures.title', 'procedures.ext_procedure_id')->get();
    }

}

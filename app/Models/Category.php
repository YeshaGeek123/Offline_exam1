<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'procedure_id',
        'ext_category_id',
        'title',
    ];

    public function procedure() 
    {
        return DB::table('categories')->select('categories.id', 'categories.procedure_id', 'categories.title', DB::raw('GROUP_CONCAT(procedures.title SEPARATOR ", ") AS pro_title'))->join('procedures', function ($join) {$join->fromRaw('FIND_IN_SET(procedures.id, categories.procedure_id)');})->whereRaw('FIND_IN_SET(procedures.id, categories.procedure_id) > 0')->groupBy('categories.id', 'categories.procedure_id', 'categories.title', 'categories.ext_category_id')->get();
    }
}

<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudentsImport implements ToModel, WithStartRow
{
    public function __construct($exam) 
    {
        $this->exam = $exam;
    }

    public function startRow(): int
    {
        return 2;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            'name' => $row[1],
            'email' => $row[2],
            // 'address' => $row[3],
            'phone' => $row[4],
            'cubicle' => $row[5],
            'code' => $this->exam->code . '-' . !empty($row[6]) ? $row[6] : Str::random(4),
            'exam_id' => $this->exam->id,
        ]);
    }
}

<?php

namespace App\Imports;

use App\Models\Exam;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class FifthSheetImport implements ToModel, WithStartRow
{
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
        $exam = Exam::where('ext_exam_id', $row[0])->select('id')->firstOrFail();

        return new Student([
            'exam_id' => $exam->id,
            'sequence_number' => $row[1],
            'ext_student_id' => $row[2],
            'name' => $row[5] . ' ' . $row[4],
            'email' => $row[6],
            'address' => $row[9],
            'social' => $row[3],
            'school' => $row[7],
            'graduation_date' => date('Y-m-d', strtotime($row[8]))
        ]);
    }
}

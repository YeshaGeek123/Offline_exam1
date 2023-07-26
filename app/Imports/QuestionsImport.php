<?php

namespace App\Imports;

use App\Models\ExamQuestion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class QuestionsImport implements ToModel, WithStartRow
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
        return new ExamQuestion([
            'exam_id' => $this->exam->id,
            'question' => $row[1],
            'option_one' => $row[2],
            'option_two' => $row[3],
            'option_three' => !empty($row[4]) ? $row[4] : null,
            'option_four' => !empty($row[5]) ? $row[5] : null,
            'option_five' => !empty($row[6]) ? $row[6] : null,
            'option_one_marks' => $row[7],
            'option_two_marks' => $row[8],
            'option_three_marks' => !empty($row[9]) ? $row[9] : null,
            'option_four_marks' => !empty($row[10]) ? $row[10] : null,
            'option_five_marks' => !empty($row[11]) ? $row[11] : null,
        ]);
    }
}

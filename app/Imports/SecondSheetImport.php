<?php

namespace App\Imports;

use App\Models\Exam;
use App\Models\Section;
use App\Models\ExamSection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SecondSheetImport implements ToModel, WithStartRow
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
        
        $section = Section::where('ext_section_id', $row[1])->first();

        if ( !empty($section) ) {
            return new ExamSection([
                'exam_id' => $exam->id,
                'section_id' => $section->id
            ]);
        }
        else {
            $newSection = Section::create([
                'ext_section_id' => $row[1],
                'title' => $row[2]
            ]);

            return new ExamSection([
                'exam_id' => $exam->id,
                'section_id' => $newSection->id
            ]);
        }

        
    }
}

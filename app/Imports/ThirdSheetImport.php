<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\Section;
use App\Models\AllSection;
use App\Models\ExamSection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ThirdSheetImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\WEloquent\Model|null
    */
    public function model(array $row)
    {
        $section = Section::where('ext_section_id', $row[0])->select('id')->firstOrFail();
        $examId = session('exam-import');
        $examSection = ExamSection::where([ ['section_id', $section->id], ['exam_id', $examId] ])->firstOrFail();

        return new Group([
            'exam_section_id' => $examSection->id,
            'ext_group_id' => $row[1],
            'title' => $row[2]
        ]);
    }
}

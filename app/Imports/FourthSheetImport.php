<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\Student;
use App\Models\GroupStudent;
use App\Models\Section;
use App\Models\SectionStudent;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class FourthSheetImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $group = Group::where('ext_group_id', $row[3])->firstOrFail();
            $student = Student::where('ext_student_id', $row[5])->firstOrFail();

            GroupStudent::create([
                'group_id' => $group->id,
                'student_id' => $student->id,
            ]);

            $section = Section::where('ext_section_id', $row[1])->firstOrFail();

            SectionStudent::create([
                'section_id' => $section->id,
                'student_id' => $student->id,
            ]);
        }
    }
}

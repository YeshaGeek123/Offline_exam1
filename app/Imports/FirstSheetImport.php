<?php

namespace App\Imports;

use App\Models\Exam;
use App\Services\ExamService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class FirstSheetImport implements ToCollection, WithStartRow
{
    private $request;

    public function __construct($request) 
    {
        $this->request = $request;
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
    public function collection(Collection $rows)
    {
        foreach ( $rows as $key => $row ) {
            if ( $key >= 1 ) break;
            
            if ( Exam::where('ext_exam_id', $row[0])->exists() ) abort(400, 'Duplicate exam.');

            $exam = Exam::create([
                'ext_exam_id' => $row[0],
                'code' => $row[1],
                'exam_start' => date('Y-m-d H:i:s', strtotime($row[2])),
                'exam_end' => date('Y-m-d H:i:s', strtotime($row[3])),
                'type' => $row[4],
                'facility_name' => $row[5],
                'state' => $row[6],
                'zip' => $row[7],
                'address' => $row[8],
                'status' => 2,
            ]);

            session(['exam-import' => $exam->id]);

            $examService = new ExamService();
            $examService->handleExamUsers($this->request, $exam);
        }
    }
}

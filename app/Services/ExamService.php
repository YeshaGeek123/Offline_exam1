<?php

namespace App\Services;

use App\Models\Student;
use App\Imports\ExamImport;
use App\Models\ExamQuestion;
use App\Imports\StudentsImport;
use App\Imports\QuestionsImport;
use App\Imports\ExamDetailsImport;
use Maatwebsite\Excel\Facades\Excel;

class ExamService {
    public function handleStudentFile($request, $exam, $isEdit = false) 
    {
        if ( $isEdit ) Student::where('exam_id', $exam->id)->delete();

        $fileName = time() . '-' . $request->studentsinput->getClientOriginalName();
        $request->studentsinput->move(public_path('storage/' . 'students-enrollment'), $fileName);

        Excel::import(new StudentsImport($exam), public_path('/storage/students-enrollment/'.$fileName));
    }

    public function handleQuestionFile($request, $exam, $isEdit = false) 
    {
        if ( $isEdit ) ExamQuestion::where('exam_id', $exam->id)->delete();

        $fileName = time() . '-' . $request->questionsinput->getClientOriginalName();
        $request->questionsinput->move(public_path('storage/' . 'questionnaire'), $fileName);

        Excel::import(new QuestionsImport($exam), public_path('/storage/questionnaire/'.$fileName));
    }

    public function handleExamUsers($request, $exam, $isEdit = false) 
    {
        $finalArray = array_merge($request->evaluators, $request->assistants, $request->invigilators, [$request->manager]);
        
        if ( $isEdit )
            $exam->users()->sync($finalArray);
        else
            $exam->users()->attach($finalArray);
    }

    public function handleExamFile($request) 
    {
        $fileName = time() . '-' . $request->examinput->getClientOriginalName();
        $request->examinput->move(public_path('storage/' . 'examupload'), $fileName);

        $import1 = new ExamDetailsImport($request);
        $import1->onlySheets(0);
        Excel::import($import1, public_path('/storage/examupload/'.$fileName));

        $import2 = new ExamDetailsImport($request);
        $import2->onlySheets(1, 2, 4);
        Excel::import($import2, public_path('/storage/examupload/'.$fileName));

        $import3 = new ExamDetailsImport($request);
        $import3->onlySheets(3);
        Excel::import($import3, public_path('/storage/examupload/'.$fileName));

        // session()->forget('exam-import');
    }
}
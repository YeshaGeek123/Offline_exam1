<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index() 
    {
        $newData = [];

        $results = Evaluation::with(['evaluator', 'student', 'exam_question.exam'])
            ->get()
            ->groupBy(function($item, $key) {
                return $item['student_id'].$item['user_id'];
            });

        foreach ($results as $key => $value) {
            $marksObtained = $fullMarks = 0;
            foreach ($value as $k => $v) {
                $fullMarks += max($v->exam_question->option_one_marks, $v->exam_question->option_two_marks, $v->exam_question->option_three_marks, $v->exam_question->option_four_marks, $v->exam_question->option_five_marks, );
                $marksObtained += $v->marks;
            }
            $newData[$key]['id'] = $v->id;
            $newData[$key]['exam'] = $v->exam_question->exam->title;
            $newData[$key]['student'] = $v->student->name;
            $newData[$key]['evaluator'] = $v->evaluator->name;
            $newData[$key]['full_marks'] = $fullMarks;
            $newData[$key]['obtained_marks'] = $marksObtained;
        }

        return view('results.index', compact('newData'));
    }
}

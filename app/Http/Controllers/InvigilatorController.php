<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Student;
use Illuminate\Http\Request;

class InvigilatorController extends Controller
{
    public function dashboard() 
    {
        $exams = Exam::whereHas('users', function($q) {
            $q->where('users.id', auth()->id());
        })->get();

        return view('invigilator-dashboard', compact('exams'));
    }

    public function studentsList(Exam $exam) 
    {
        $students = Student::where('exam_id', $exam->id)->with('exam')->get();

        return view('students.index', compact('students', 'exam'));
    }

    public function markPresent($student, $status) 
    {
        $student = Student::where('id', $student)->firstOrFail();

        $student->update(['is_present' => $status]);

        return response()->json(['success' => true]);
    }
}

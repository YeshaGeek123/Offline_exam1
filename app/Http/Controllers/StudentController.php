<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\NameService;
use App\Http\Requests\StudentRequest;
use App\Models\GroupStudent;
use App\Models\NewEvaluation;
use App\Models\Section;

class StudentController extends Controller
{
    public function create($examid) 
    {
        return view('students.create', compact('examid'));
    }

    public function store(StudentRequest $request) 
    {
        if ( Student::where('exam_id', $request->exam_id)->where('sequence_number', $request->sequence_number)->exists() ) return back()->with('error', 'Duplicate sequence number')->withInput();

        $request->merge(['name' => $request->first_name.' '.$request->last_name]);

        Student::create($request->all());

        return redirect(route('exams.show', $request->exam_id))->with('success', 'Data saved.');
    }

    public function show(Student $student) 
    {
        $student->load(['exam', 'sections']);
        // dd($student->toArray());
        
        return view('students.show', compact('student'));
    }

    public function edit(Student $student, NameService $nameService) 
    {
        $name = $nameService->breakdownName($student->name);

        return view('students.edit', compact('student', 'name'));
    }

    public function update(StudentRequest $request, Student $student) 
    {
        if ( Student::where('exam_id', $request->exam_id)->where('sequence_number', $request->sequence_number)->where('id', '!=', $student->id)->exists() ) return back()->with('error', 'Duplicate sequence number')->withInput();

        $request->merge(['name' => $request->first_name.' '.$request->last_name]);

        $student->update($request->all());

        return redirect(route('exams.show', $request->exam_id))->with('success', 'Data updated.');
    }

    public function destroy(Student $student) 
    {
        $eid = $student->exam_id;

        $student->delete();

        return redirect(route('exams.show', $eid))->with('success', 'Data deleted.'); 
    }
}

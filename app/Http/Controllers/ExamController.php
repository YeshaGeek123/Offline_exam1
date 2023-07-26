<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Exam;
use App\Models\User;
use App\Models\Cubicle;
use App\Services\ExamService;
use App\Http\Requests\ExamRequest;
use App\Models\Criteria;
use App\Models\Fail;
use App\Models\NewEvaluation;
use App\Models\Procedure;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = Exam::get();

        return view('exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cubicles = Cubicle::get();
        $users = User::where('role_id', '!=', 1)->select('id', 'name', 'role_id')->get();
        
        return view('exams.create', compact('users', 'cubicles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamRequest $request, ExamService $examService)
    {
        DB::beginTransaction();
        try {
            $examService->handleExamFile($request);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }

        return redirect(route('exams.index'))->with('success', 'Data saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        $exam->load(['users', 'students', 'sections']);

        return view('exams.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit($exam)
    {
        $cubicles = Cubicle::get();
        $exam = Exam::where('id', $exam)->firstOrFail();
        $userIds = $exam->getUserIds()->toArray();
        $users = User::where('role_id', '!=', 1)->select('id', 'name', 'role_id')->get();

        return view('exams.edit', compact('exam', 'users', 'userIds', 'cubicles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(ExamRequest $request, Exam $exam, ExamService $examService)
    {
        DB::beginTransaction();
        try {
            $exam->update($request->all());
            $examService->handleExamUsers($request, $exam, true);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }

        return redirect(route('exams.index'))->with('success', 'Data updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect(route('exams.index'))->with('success', 'Data deleted.');
    }

    public function toggleStatus($id, $status) 
    {
        $exam = Exam::where('id', $id)->firstOrFail();

        if ( $status == 1 ) {
            $exam->update(['status' => 2]);
        }
        else {
            Exam::where('id', '!=', $id)->update(['status' => 2]);

            $exam->update(['status' => 1]);
        }

        return back()->with('success', 'Data updated.');
    }

    public function getFailedCriterias($id) 
    {
        return response()->json([
            'criterias' => Criteria::with('questionnaire:id,title')->whereHas('fails', function($q) use($id) {
                $q->where('new_evaluation_id', $id);
            })->get()->groupBy('questionnaire_id')
        ]);
    }

    public function progressTable(Exam $exam) 
    {
        $exam->load(['users', 'students', 'sections']);

        $students = Student::where('exam_id', $exam->id)->with(['sections', 'groups.section'])->get()->map(function($student) {
            $student->sectionids = $student->sections()->pluck('sections.id')->toArray();

            return $student;
        });

        $studentIds = $students->pluck('id')->toArray();

        $evalutaions = NewEvaluation::whereIn('student_id', $studentIds)->get();

        $procedures = Procedure::with('section')->get();

        $colors = [
            '#403A3A',
            '#d571c8',
            '#3b9cca',
            '#7E7B52',
            '#035da6',
            '#B44C43',
            '#5e533e',
            '#0e811d',
            '#6F4F28',
            '#62a4fc',
            '#fccb02',
            '#ee10de',
            '#98381e',
            '#a5b49f',
            '#9a3f75',
            '#746ea9',
            '#c063f7',
            '#276785',
            '#287222',
            '#59616e'
        ];

        return view('exams.progress', compact('students', 'exam', 'procedures', 'evalutaions', 'colors'));
    }
    
    public function progressTableAjax(Exam $exam) 
    {
        $exam->load(['users', 'students', 'sections']);

        $students = Student::where('exam_id', $exam->id)->with(['sections', 'groups.section'])->get()->map(function($student) {
            $student->sectionids = $student->sections()->pluck('sections.id')->toArray();

            return $student;
        });

        $studentIds = $students->pluck('id')->toArray();

        $evalutaions = NewEvaluation::whereIn('student_id', $studentIds)->get();

        $procedures = Procedure::with('section')->get();

        $colors = [
            '#403A3A',
            '#d571c8',
            '#3b9cca',
            '#7E7B52',
            '#035da6',
            '#B44C43',
            '#5e533e',
            '#0e811d',
            '#6F4F28',
            '#62a4fc',
            '#fccb02',
            '#ee10de',
            '#98381e',
            '#a5b49f',
            '#9a3f75',
            '#746ea9',
            '#c063f7',
            '#276785',
            '#287222',
            '#59616e'
        ];

        return response()->json([ 'html' => view('exams.progress-ajax', compact('students', 'exam', 'procedures', 'evalutaions', 'colors'))->render() ]);
    }
}

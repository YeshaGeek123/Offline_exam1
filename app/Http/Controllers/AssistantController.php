<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Exam;
use App\Models\Cubicle;
use App\Models\Student;
use App\Events\CleanedUp;
use App\Models\Submission;
use App\Events\NeedCleanup;
use App\Models\WaitingRoom;
use Illuminate\Http\Request;
use App\Models\NewEvaluation;
use App\Events\AssignedToCubicle;
use App\Events\AssistantSubmitted;
use Illuminate\Support\Facades\DB;
use App\Services\AssignNewEvaluatorService;

class AssistantController extends Controller
{
    public function dashboard() 
    {
        $activeExam = Exam::where('status', 1)->with(['sections', 'cubicles'])->firstOrFail();
        $students = Student::where('exam_id', $activeExam->id)->where('is_terminated', 0)->get();

        return view('assistant-dashboard', compact('activeExam', 'students'));
    }

    public function getExamCubicles($examid) 
    {
        return response()->json(['cubicles' => Cubicle::whereHas('exams', function($q) use($examid) { $q->where('exam_id', $examid); })->get()]);
    }

    public function accept(Request $request) 
    {
        $student = Student::where('id', $request->student_id)->with('exam')->select('id', 'code', 'exam_id', 'submission_cubicle', 'is_being_evaluated')->firstOrFail();

        try {
            if ( $request->cubicle_id == 0 ) {
                WaitingRoom::create(['student_id' => $request->student_id]);
            }
            else {
                DB::table('notifications')->where('data->student->id', $request->student_id)->where('data->exam->id', $request->exam_id)->delete();
                // $student->update(['submission_cubicle' => $request->cubicle]);
                Submission::create([
                    'cubicle_id' => $request->cubicle_id,
                    'student_id' => $request->student_id
                ]);
            }
        }
        catch (Exception $e) {
            return response()->json(['success' => false]);
        }

        AssistantSubmitted::dispatch($student, $request->exam_id);

        return response()->json(['success' => true]);
    }

    public function assignToCubicle(Request $request, AssignNewEvaluatorService $assignService) 
    {
        $request->validate([
            'type' => 'required',
            'student_code' => 'required'
        ]);

        $activeExam = Exam::where('status', 1)->firstOrFail();
        $student = Student::where('sequence_number', $request->student_code)->where('exam_id', $activeExam->id)->firstOrFail();

        if ( $request->type == 1 ) {
            if ( NewEvaluation::where('cubicle_id', $request->cubicle_id)->where('is_ongoing', 1)->exists() ) return back()->with('error', 'Operatory is occupied!');

            $assignService->firstCubicleAssign($activeExam, $request, $student);
        }
        else {
            WaitingRoom::create([
                'student_id' => $student->id
            ]);
        }

        return redirect(route('assistant-dashboard'))->with('success', 'Data saved.');
    }
    
    public function assignToCubicleFromWaitingRoom(Request $request, AssignNewEvaluatorService $assignService) 
    {
        $request->validate([
            'student_id' => 'required',
            'section_id' => 'required',
            'procedure_id' => 'required',
            'cubicle_id' => 'required'
        ]);

        $activeExam = Exam::where('status', 1)->firstOrFail();

        if ( NewEvaluation::where('cubicle_id', $request->cubicle_id)->where('is_ongoing', 1)->exists() ) return back()->with('error', 'Operatory is occupied!');

        $assignService->firstCubicleAssignFromWaitingRoom($activeExam, $request);

        WaitingRoom::where('student_id', $request->student_id)->delete();

        return redirect(route('assistant-waiting-room'))->with('success', 'Data saved.');
    }

    public function waitingRoom() 
    {
        $activeExam = Exam::where('status', 1)->with(['sections', 'cubicles'])->firstOrFail();
        $students = WaitingRoom::with('student:id,sequence_number')->get();
          
        return view('waiting-room', compact('students', 'activeExam'));
    }

    public function resetCubicle(Request $request) 
    {
        $request->validate([
            'cubicle_id' => 'required'
        ]);

        NewEvaluation::where([
            ['cubicle_id', $request->cubicle_id],
            ['is_ongoing', 1]
        ])->delete();

        CleanedUp::dispatch($request->cubicle_id);

        return redirect(route('assistant-dashboard'))->with('success', 'Operatory reset.');
    }

    public function showTerminationForm() 
    {
        return view('termination-form');
    }

    public function termination(Request $request) 
    {
        $activeExam = Exam::where('status', 1)->with(['sections', 'cubicles'])->firstOrFail();

        $student = Student::whereSequenceNumber($request->student_code)->where('exam_id', $activeExam->id)->firstOrFail();

        $student->update([
            'is_terminated' => 1,
            'reason' => $request->reason
        ]);

        $evaluation = NewEvaluation::where('student_id', $student->id)->where('is_ongoing', 1)->oldest()->first();
        Cubicle::where('id', $evaluation->cubicle_id)->update(['need_cleanup' => 1]);
                
        NeedCleanup::dispatch($evaluation->cubicle_id);

        return back()->with('success', 'Student terminated.');
    }
}

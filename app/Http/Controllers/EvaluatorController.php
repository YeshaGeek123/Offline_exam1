<?php

namespace App\Http\Controllers;

use App\Models\Fail;
use App\Models\Group;
use App\Models\Cubicle;
use App\Models\Student;
use App\Models\Evaluation;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\NewEvaluation;
use App\Models\Questionnaire;
use App\Events\EvaluationEnded;
use App\Events\EvaluationStarted;
use Illuminate\Support\Facades\Auth;
use App\Events\NeedCleanup;
use App\Http\Requests\EvaluatorLoginRequest;
use App\Services\AssignNewEvaluatorService;

class EvaluatorController extends Controller
{
    public function dashboard()
    {
        $evaluation = NewEvaluation::where('user_id', auth()->id())->orderByDesc('created_at')->with('student')->firstOrFail();
        $groups = Group::whereIn('id', $evaluation->student->group_ids)->with('section.section')->get();
        // dd($groups->toArray());

        return view('evaluator-dashboard', compact('groups', 'evaluation'));
    }

    public function evaluateForm(Request $request)
    {
        // $request->validate([
        //     'evaluation_id' => 'required',
        //     'is_first' => 'required',
        // ]);


        $evaluation = NewEvaluation::where('section_id', $request->all_section_id)->with('student.exam', 'section', 'procedure')->firstOrFail();
        $student = $evaluation->student;

        $questionnaires = Questionnaire::where('section_id', $evaluation->section_id)->where('procedure_id', $evaluation->procedure_id)->with('criterias')->get();
        $session = session('srta-kindle-identifier');

        return view('evaluations.create', compact('questionnaires', 'student', 'evaluation'));
    }

    public function evaluateSubmit(Request $request)
    {
        $student = Student::where('id', $request->student_id)->select('id', 'exam_id', 'code', 'is_being_evaluated', 'submission_cubicle')->with('exam')->firstOrFail();

        $submission = Submission::where('student_id', $request->student_id)->firstOrFail();

        foreach ($request->question as $id => $q) {
            Evaluation::create([
                'user_id' => auth()->id(),
                'exam_question_id' => $id,
                'student_id' => $request->student_id,
                'marks' => $q['marks'],
                'remarks' => $q['remarks']
            ]);
        }

        $submission->update(['is_being_evaluated' => 0, 'is_being_evaluated_by' => null]);

        EvaluationEnded::dispatch($student, auth()->id());

        return redirect(route('evaluator-dashboard'))->with('success', 'Data saved.');
    }

    public function evaluateSubmitPass(Request $request, AssignNewEvaluatorService $assignService)
    {
        $session = session('srta-kindle-identifier');
        $cubicle = Cubicle::where('identifier', $session)->firstOrFail();

        $evaluation = NewEvaluation::where('id', $request->id)->firstOrFail();

        if ( NewEvaluation::where([ ['cubicle_id', $cubicle->id], ['student_id', $evaluation->student_id], ['section_id', $evaluation->section_id], ['procedure_id', $evaluation->procedure_id], ['is_ongoing', 1] ])->count() == 3 ) {
            $evaluation->update(['status' => 2, 'is_ongoing' => 0]);

            if (NewEvaluation::where([ ['cubicle_id', $cubicle->id], ['student_id', $evaluation->student_id], ['section_id', $evaluation->section_id], ['procedure_id', $evaluation->procedure_id], ['is_ongoing', 1] ])->where('status', 3)->exists()  ) {
                $assignService->failScenario($session, $evaluation->id);

                Auth::guard('web')->logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect(route('kindle-dashboard', $session))->with('success', 'Data saved.');
            }
            else {
                NewEvaluation::where('cubicle_id', $evaluation->cubicle_id)->where('student_id', $evaluation->student_id)->where('section_id', $evaluation->section_id)->where('procedure_id', $evaluation->procedure_id)->update(['is_ongoing' => 0]);

                Cubicle::where('id', $evaluation->cubicle_id)->update(['need_cleanup' => 1]);

                NeedCleanup::dispatch($evaluation->cubicle_id);

                Auth::guard('web')->logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect(route('cleanup', $cubicle->id))->with('success', 'Data saved.');
            }
        }
        else {
            $evaluation->update(['status' => 2]);

            $assignService->assignNewEvaluator($session, $evaluation);

            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect(route('kindle-dashboard', $session))->with('success', 'Data saved.');
        }

    }

    public function evaluateSubmitFail(Request $request, AssignNewEvaluatorService $assignService)
    {
        $evaluation = NewEvaluation::where('id', $request->id)->firstOrFail();

        $evaluation->update(['status' => 3]);

        foreach($request->criteria_id as $cr) {
            Fail::create([
                'new_evaluation_id' => $request->id,
                'criteria_id' => $cr,
            ]);
        }

        $session = session('srta-kindle-identifier');

        if ( NewEvaluation::where([ ['cubicle_id', $evaluation->cubicle_id], ['student_id', $evaluation->student_id], ['section_id', $evaluation->section_id], ['procedure_id', $evaluation->procedure_id], ['is_ongoing', 1] ])->count() == 3 ) {
            $assignService->failScenario($session, $evaluation->id);
        }
        else {
            $assignService->assignNewEvaluator($session, $evaluation);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('kindle-dashboard', $session))->with('success', 'Data saved.');
    }

    public function closeConnention($id)
    {
        $student = Student::where('id', $id)->with('exam')->firstOrFail();
        EvaluationEnded::dispatch($student, auth()->id());

        return $student->update(['is_being_evaluated' => 0, 'is_being_evaluated_by' => null]);
    }

    public function openConnention($id)
    {
        $student = Student::where('id', $id)->with('exam')->firstOrFail();
        EvaluationStarted::dispatch($student, auth()->user());

        return $student->update(['is_being_evaluated' => 1, 'is_being_evaluated_by' => auth()->id()]);
    }

    public function login(EvaluatorLoginRequest $request)
    {
        $cubicle = Cubicle::where('identifier', session('srta-kindle-identifier'))->firstOrFail();

        $request->authenticate();

        if ( $cubicle->has_failed ) {
            if ( auth()->user()->role_id != 5 ) {
                $this->logoutUser($request);

                return back()->with('error', 'You are not assigned to this cubicle.');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('manager-dashboard', $cubicle->id));
        }
        else {
            if ( auth()->user()->role_id != 2 ) {
                $this->logoutUser($request);

                return back()->with('error', 'You are not assigned to this cubicle.');
            }

            $evaluation = NewEvaluation::where([ ['cubicle_id', $cubicle->id], ['user_id', auth()->id()], ['status', '<', 2], ['is_ongoing', 1] ])->latest()->first();

            if ( empty($evaluation) ) {
                $this->logoutUser($request);

                return back()->with('error', 'You are not assigned to this cubicle.');
            }

            $evaluation->update(['status' => 1]);

            $request->session()->regenerate();

            EvaluationStarted::dispatch($evaluation->id);

            if ( NewEvaluation::where([ ['cubicle_id', $cubicle->id], ['student_id', $evaluation->student_id], ['section_id', $evaluation->section_id], ['procedure_id', $evaluation->procedure_id] ])->count() == 1 )
                return redirect()->intended(route('evaluator-evaluate-form', ['evaluation_id' => $evaluation->id, 'is_first' => true]));
            else
                return redirect()->intended(route('evaluator-evaluate-form', ['evaluation_id' => $evaluation->id, 'is_first' => false]));
        }
    }

    private function logoutUser($request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
    }

    public function confirmEvaluation($id)
    {
        NewEvaluation::where('id', $id)->update(['confirmation_status' => 1]);

        EvaluationStarted::dispatch($id);

        return response()->json(['result' => true]);
    }

    public function failureCriterias(Request $request)
    {
        $evid = $request->evaluation_id;

        $questionnaires = Questionnaire::whereIn('id', $request->questionnaires)->with([
            'criterias' => function($q) {
                $q->where('is_acceptable', 0);
            }
        ])->get();

        return response()->json(['view' => view('evaluations.criterias', compact('questionnaires', 'evid'))->render()]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Fail;
use App\Models\Cubicle;
use App\Models\Student;
use App\Events\NeedCleanup;
use Illuminate\Http\Request;
use App\Models\NewEvaluation;
use App\Models\Questionnaire;
use App\Services\ManagerService;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function managerDashboard($cubicle) 
    {
        $evaluations = NewEvaluation::where([ ['cubicle_id', $cubicle], ['is_ongoing', 1] ])->with(['section', 'procedure'])->get();
        $student = Student::find($evaluations->first()->student_id);
        $evaluationIds = $evaluations->pluck('id')->toArray();

        $failedCriterias = Fail::whereIn('new_evaluation_id', $evaluationIds)->with(['criteria.questionnaire', 'evaluation.user'])->get()->groupBy(['new_evaluation_id', 'criteria.questionnaire_id']);

        return view('manager-dashboard', compact('student', 'evaluations', 'failedCriterias'));
    }

    public function pass(Request $request) 
    {
        NewEvaluation::where([ ['cubicle_id', $request->cubicle_id], ['is_ongoing', 1] ])->update(['is_ongoing' => 0, 'status' => 2]);

        Cubicle::where('id', $request->cubicle_id)->update(['need_cleanup' => 1, 'has_failed' => 0]);
                
        NeedCleanup::dispatch($request->cubicle_id);

        $this->logoutUser($request);

        return redirect(route('cleanup', $request->cubicle_id))->with('success', 'Data saved.');
    }

    public function reevaluate(Request $request, ManagerService $managerService) 
    {
        $cubicle = Cubicle::where('id', $request->cubicle_id)->firstOrFail();

        $ongoing = NewEvaluation::where([ ['cubicle_id', $request->cubicle_id], ['is_ongoing', 1] ])->get();
        NewEvaluation::where([ ['cubicle_id', $request->cubicle_id], ['is_ongoing', 1] ])->update(['is_ongoing' => 0]);
        
        $managerService->assignNewEvaluator($request->cubicle_id, $ongoing);

        $cubicle->update(['has_failed' => 0]);

        $this->logoutUser($request);

        return redirect(route('kindle-dashboard', $cubicle->identifier))->with('success', 'Data saved.');
    }

    private function logoutUser($request)
    {
        Auth::guard('web')->logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}

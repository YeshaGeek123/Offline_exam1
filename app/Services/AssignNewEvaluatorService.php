<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\Cubicle;
use App\Models\NewEvaluation;
use App\Events\AssignedToCubicle;
use App\Events\TwoFailed;

class AssignNewEvaluatorService {

    public function assignNewEvaluator($session, $evaluation)
    {
        $cubicle = Cubicle::where('identifier', $session)->firstOrFail();
        $activeExam = Exam::where('status', 1)->firstOrFail();

        $ongoing = NewEvaluation::where('cubicle_id', $evaluation->cubicle_id)->where('student_id', $evaluation->student_id)->where('section_id', $evaluation->section_id)->where('procedure_id', $evaluation->procedure_id)->where('is_ongoing', 1)->first();

        $alreadyEvaluatedUsers = NewEvaluation::where('cubicle_id', $evaluation->cubicle_id)->where('student_id', $evaluation->student_id)->where('section_id', $evaluation->section_id)->where('procedure_id', $evaluation->procedure_id)->where('is_ongoing', 1)->get()->pluck('user_id')->toArray();

        if ( $ongoing->round > 1 ) {
            $previousRoundEvaluators =  NewEvaluation::where('cubicle_id', $evaluation->cubicle_id)->where('student_id', $evaluation->student_id)->where('section_id', $evaluation->section_id)->where('procedure_id', $evaluation->procedure_id)->where('is_ongoing', 0)->where('round', ($ongoing->round - 1))->get()->pluck('user_id')->toArray();

            $alreadyEvaluatedUsers = array_unique(array_merge($previousRoundEvaluators, $alreadyEvaluatedUsers));
        }

        if ( $activeExam->users()->where('role_id', 2)->whereNotIn('users.id', $alreadyEvaluatedUsers)->exists() )
            $randomEvaluator = $activeExam->users()->where('role_id', 2)->whereNotIn('users.id', $alreadyEvaluatedUsers)->get()->random(1)->first();
        else
            $randomEvaluator = $activeExam->users()->where('role_id', 2)->get()->random(1)->first();

        $newev = NewEvaluation::create([
            'cubicle_id' => $cubicle->id,
            'user_id' => $randomEvaluator->id,
            'student_id' => $evaluation->student_id,
            'section_id' => $evaluation->section_id,
            'procedure_id' => $evaluation->procedure_id,
            'status' => 0,
            'confirmation_status' => 1,
            'round' => $ongoing->round
        ]);


        $newev->load(['student', 'user']);

        AssignedToCubicle::dispatch($newev->toArray());
    }

    public function failScenario($session, $eid)
    {
        $cubicle = Cubicle::where('identifier', $session)->firstOrFail();
        $cubicle->update(['has_failed' => 1]);

        $activeExam = Exam::where('status', 1)->firstOrFail();
        $manager = $activeExam->users()->where('role_id', 5)->first();

        TwoFailed::dispatch($cubicle, $manager, $eid);
    }

    public function firstCubicleAssign($activeExam, $request, $student)
    {
        // $alreadyEvaluatedUsers = NewEvaluation::where('cubicle_id', $request->cubicle_id)->where('student_id', $student->id)->where('section_id', $request->section_id)->where('procedure_id', $request->procedure_id)->get()->pluck('user_id')->toArray();
        // $randomEvaluator = $activeExam->users()->where('role_id', 2)->whereNotIn('users.id', $alreadyEvaluatedUsers)->get()->random(1)->first();
        $randomEvaluator = $activeExam->users()->where('role_id', 2)->get()->random(1)->first();

        $newev = NewEvaluation::create([
            'cubicle_id' => $request->cubicle_id,
            'user_id' => $randomEvaluator->id,
            'student_id' => $student->id,
            'section_id' => $request->section_id,
            'procedure_id' => $request->procedure_id,
            'status' => 0
        ]);

        $newev->load(['student', 'user']);

        AssignedToCubicle::dispatch($newev->toArray());
    }

    public function firstCubicleAssignFromWaitingRoom($activeExam, $request)
    {
        // $alreadyEvaluatedUsers = NewEvaluation::where('cubicle_id', $request->cubicle_id)->where('student_id', $request->student_id)->where('section_id', $request->section_id)->where('procedure_id', $request->procedure_id)->get()->pluck('user_id')->toArray();
        // $randomEvaluator = $activeExam->users()->where('role_id', 2)->whereNotIn('users.id', $alreadyEvaluatedUsers)->get()->random(1)->first();
        $randomEvaluator = $activeExam->users()->where('role_id', 2)->get()->random(1)->first();

        $newev = NewEvaluation::create([
            'cubicle_id' => $request->cubicle_id,
            'user_id' => $randomEvaluator->id,
            'student_id' => $request->student_id,
            'section_id' => $request->section_id,
            'procedure_id' => $request->procedure_id,
            'status' => 0
        ]);

        $newev->load(['student', 'user']);

        AssignedToCubicle::dispatch($newev->toArray());
    }

}

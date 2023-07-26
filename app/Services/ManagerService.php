<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\Cubicle;
use App\Models\NewEvaluation;
use App\Events\AssignedToCubicle;

class ManagerService {

    public function assignNewEvaluator($cubicleid, $ongoing)
    {
        $activeExam = Exam::where('status', 1)->firstOrFail();

        $alreadyEvaluatedUsers = $ongoing->pluck('user_id')->toArray();

        if ( $activeExam->users()->where('role_id', 2)->whereNotIn('users.id', $alreadyEvaluatedUsers)->exists() ) 
            $randomEvaluator = $activeExam->users()->where('role_id', 2)->whereNotIn('users.id', $alreadyEvaluatedUsers)->get()->random(1)->first();
        else 
            $randomEvaluator = $activeExam->users()->where('role_id', 2)->get()->random(1)->first();

        $newev = NewEvaluation::create([
            'cubicle_id' => $cubicleid,
            'user_id' => $randomEvaluator->id,
            'student_id' => $ongoing->first()->student_id,
            'section_id' => $ongoing->first()->section_id,
            'procedure_id' => $ongoing->first()->procedure_id,
            'status' => 0,
            'confirmation_status' => 1,
            'round' => $ongoing->first()->round + 1
        ]);

        $newev->load(['student', 'user']);

        AssignedToCubicle::dispatch($newev->toArray());
    }
}
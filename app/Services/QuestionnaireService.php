<?php

namespace App\Services;

use App\Models\Criteria;

class QuestionnaireService {
    public function storeCriterias($criterias, $id) 
    {
        if ( !empty($criterias) ) {
            foreach($criterias as $cr) {
                Criteria::create([
                    'questionnaire_id' => $id,
                    'title' => $cr['criteria'],
                    'is_acceptable' => isset($cr['is_acceptable']) ? 1: 0,
                ]);
            }
        }
    }

    public function updateOldCriterias($criterias) 
    {
        if ( !empty($criterias) ) {
            foreach($criterias as $cr) {
                if ( $cr['to_delete'] == 'true' ) {
                    Criteria::destroy($cr['id']);
                }
                else {
                    Criteria::where('id', $cr['id'])->update([
                        'title' => $cr['criteria'],
                        'is_acceptable' => isset($cr['is_acceptable']) ? 1: 0,
                    ]);
                }
            }
        }
    }
}
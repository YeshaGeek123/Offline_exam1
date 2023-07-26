<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_evaluator'])->prefix('evaluator')->group(function () {
    Route::get('/dashboard', 'EvaluatorController@dashboard')->name('evaluator-dashboard');
    Route::get('/evaluate-form', 'EvaluatorController@evaluateForm')->name('evaluator-evaluate-form');
    Route::post('/evaluate-form-pass', 'EvaluatorController@evaluateSubmitPass')->name('evaluator-evaluate-submit-pass');
    Route::post('/evaluate-form-fail', 'EvaluatorController@evaluateSubmitFail')->name('evaluator-evaluate-submit-fail');
    Route::get('/close/{id}', 'EvaluatorController@closeConnention');
    Route::get('/open/{id}', 'EvaluatorController@openConnention');
    Route::post('/confirm-evaluation/{id}', 'EvaluatorController@confirmEvaluation')->name('evaluator-confirm-evaluation');
    Route::post('/failure-criterias', 'EvaluatorController@failureCriterias')->name('evaluator-failure-criterias');
});
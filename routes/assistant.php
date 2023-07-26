<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_assistant'])->prefix('assistant')->group(function () {
    Route::get('/dashboard', 'AssistantController@dashboard')->name('assistant-dashboard');
    Route::post('/accept', 'AssistantController@accept')->name('assistant-accept');
    Route::get('/get-exam-cubicles/{id}', 'AssistantController@getExamCubicles')->name('assistant-get-cubicles');
    Route::post('/assign-to-cubicle', 'AssistantController@assignToCubicle')->name('assistant-assign-to-cubicle');
    Route::post('/assistant-assign-to-cubicle-from-waiting-room', 'AssistantController@assignToCubicleFromWaitingRoom')->name('assistant-assign-to-cubicle-from-waiting-room');
    Route::get('/waiting-room', 'AssistantController@waitingRoom')->name('assistant-waiting-room');
    Route::post('/reset-cubicle', 'AssistantController@resetCubicle')->name('assistant-reset-cubicle');

    Route::get('/termination', 'AssistantController@showTerminationForm')->name('assistant-show-term-form');
    Route::post('/termination', 'AssistantController@termination')->name('assistant-termination');
});
<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_invigilator'])->prefix('invigilator')->group(function () {
    Route::get('/dashboard', 'InvigilatorController@dashboard')->name('invigilator-dashboard');
    Route::get('/students-list/{exam}', 'InvigilatorController@studentsList')->name('invigilator-student-list');
    Route::get('/mark-present/{student}/{status}', 'InvigilatorController@markPresent')->name('invigilator-mark-present');
});
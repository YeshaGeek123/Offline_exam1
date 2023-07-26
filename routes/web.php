<?php

use Illuminate\Support\Facades\Route;
use App\Events\Hello;
use App\Http\Controllers\ButtonClickedController;
use App\Events\TestEvent;


Route::get('/', 'Auth\AuthenticatedSessionController@create')->middleware('guest');

Route::get('/broadcast',function(){
    Hello::dispatch();
    return 'sent';
});

Route::get('/config-clear', function() {
    \Artisan::call('config:clear');
});



// Students
Route::view('/student/login', 'student-login')->name('student-login-form')->middleware('guest');
Route::post('/student/login', 'HomeController@studentLogin')->name('student-login')->middleware('guest');
Route::get('/student/dashboard', 'HomeController@studentDashboard')->name('student-dashboard')->middleware('guest');
Route::post('/student/finish', 'HomeController@studentFinish')->name('student-finish')->middleware('guest');

// Evaluators
// Route::view('/evaluator/login', 'evaluator-login')->name('evaluator-login-form')->middleware('guest');
Route::post('/evaluator/login', 'EvaluatorController@login')->name('evaluator-login')->middleware('guest');

// Call Board
Route::get('/call-board', 'HomeController@callBoard')->name('call-board')->middleware('guest');
Route::get('/cleanup-done/{cubicle}', 'HomeController@cleanupDone')->name('cleanup-done');
Route::get('/cleanup/{cubicle}', 'HomeController@cleanUpPage')->name('cleanup')->middleware('guest');

// Kindles
Route::get('/register-kindle', 'HomeController@registerKindleForm')->name('register-kindle-form')->middleware('guest');
Route::post('/register-kindle', 'HomeController@registerKindle')->name('register-kindle')->middleware('guest');
Route::get('/register-kindle-check/{cubicleNumber}', 'HomeController@registerKindleCheck')->name('register-kindle-check')->middleware('guest');
Route::get('/kindle-dashboard/{uuid}', 'HomeController@kindleDashboard')->name('kindle-dashboard')->middleware('guest');

Route::middleware(['auth'])->group(function () {
    Route::view('/change-password', 'change-password')->name('change-password-form');
    Route::patch('/change-password', 'HomeController@changePassword')->name('change-password');

    Route::get('/get-all-related-procedures/{id}', 'QuestionnaireController@getAllRelatedProcedures')->name('get-all-related-procedures');
    Route::get('/get-all-related-categories/{id}', 'QuestionnaireController@getAllRelatedCategories')->name('get-all-related-categories');

    // Manager
    Route::get('/manager-dashboard/{cubicle}', 'ManagerController@managerDashboard')->name('manager-dashboard')->middleware('is_manager');
    Route::post('/manager-pass', 'ManagerController@pass')->name('manager-pass')->middleware('is_manager');
    Route::post('/manager-reevaluate', 'ManagerController@reevaluate')->name('manager-reevaluate')->middleware('is_manager');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
    Route::get('/get-evaluation-details/{id}', 'ExamController@getEvaluationDetails');
    Route::get('/get-failed-criterias/{id}', 'ExamController@getFailedCriterias');

    // Exams
    Route::resource('exams', 'ExamController');
    Route::get('exams/toggle-status/{id}/{status}', 'ExamController@toggleStatus')->name('exams.toggle-status');
    Route::get('exams/{exam}/progress-table', 'ExamController@progressTable')->name('exams.progress-table');
    Route::get('exams/{exam}/progress-table-ajax', 'ExamController@progressTableAjax')->name('exams.progress-table-ajax');

    // Users
    Route::resource('users', 'UserController');

    Route::get('multiuserlogin/{id}', 'UserController@multiuserLogin')->name('users.multiuserlogin');
    Route::get('back-to-previous-dashboard', 'UserController@backToPreviousDashboard')->name('back-to-previous-dashboard');


    // Students
    Route::get('students/{examid}', 'StudentController@create')->name('students.create');
    Route::post('students', 'StudentController@store')->name('students.store');
    Route::get('student-details/{student}', 'StudentController@show')->name('students.show');
    Route::get('students/{student}/edit', 'StudentController@edit')->name('students.edit');
    Route::patch('students/{student}', 'StudentController@update')->name('students.update');
    Route::delete('students/{student}', 'StudentController@destroy')->name('students.destroy');

    // Results
    Route::get('/results', 'ResultController@index')->name('results.index');

    // Cubicles
    Route::resource('cubicles', 'CubicleController');

    Route::resource('sections', 'SectionsController');

    // Procedures
    Route::resource('procedures', 'ProceduresController');

    // Categories
    Route::resource('categories', 'CategoriesController');

    // Questionnaires
    Route::resource('questionnaires', 'QuestionnaireController');
});

require __DIR__.'/auth.php';
require __DIR__.'/evaluator.php';
require __DIR__.'/assistant.php';
require __DIR__.'/invigilator.php';

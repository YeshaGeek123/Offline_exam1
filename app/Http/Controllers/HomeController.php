<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Fail;
use App\Models\User;
use App\Models\Cubicle;
use App\Models\Student;
use App\Models\Criteria;
use App\Events\CleanedUp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NewEvaluation;
use App\Models\Questionnaire;
use function React\Promise\reduce;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

use App\Notifications\ExamFinishedNotification;
use App\Models\Notification as NotificationModel;

class HomeController extends Controller
{
    public function dashboard()
    {
        $userscount = User::where('role_id', '!=', 1)->count();
        $examscount = Exam::count();

        return view('dashboard', compact('userscount', 'examscount'));
    }

    public function changePassword(Request $request)
    {
        $user = User::find(auth()->id());

        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) return back()->with('error', 'Current password did not match. Please try again.');

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }

    public function studentLogin(Request $request)
    {
        $request->validate([
            'code' => ['required'],
        ]);



        $student = Student::where('sequence_number', $request->code)->first();

        if ( !$student ) throw ValidationException::withMessages(['error' => __('auth.failed')]);

        // Auth::loginUsingId($student->id);

        // $request->session()->regenerate();

        return redirect(route('student-dashboard',  ['token' => $request->code]));
    }

    public function studentDashboard()
    {
        $student = Student::where('sequence_number', request('token'))->firstOrFail();

        return view('student-dashboard', compact('student'));
    }

    public function studentFinish(Request $request)
    {
        $examId = $request->exam_id;
        $data['exam'] = Exam::where('id', $examId)->firstOrFail();
        $data['student'] = Student::where('id', $request->student_id)->firstOrFail();

        $users = User::whereRoleId(3)->whereHas('exams', function($q) use($examId) {
            $q->where('exams.id', $examId);
        })->get();

        $admins = User::whereRoleId(1)->get();

        Notification::send($users, new ExamFinishedNotification($data));
        Notification::send($admins, new ExamFinishedNotification($data));

        return redirect(route('student-dashboard', ['token' => $request->token, 'submitted' => 'true']))->with('success', 'Notified!');
    }

    public function callBoard()
    {

        $exam = Exam::where('status', 1)->with('cubicles.recent_evaluation', function($q) {
            $q->where('is_ongoing', 1)->orderByDesc('created_at')->with(['student', 'user']);
        })->first();

        $cubicles = $exam->cubicles;

        $evaluators = User::whereHas('exams', function($q) use($exam) {
            $q->where('exams.id', $exam->id);
        })->where('role_id', 2)->select('id', 'name')->get();

        $manager = User::whereHas('exams', function($q) use($exam) {
            $q->where('exams.id', $exam->id);
        })->where('role_id', 5)->select('id', 'name')->first();
        return view('call-board', compact('exam', 'cubicles', 'evaluators', 'manager'));

    }


    public function registerKindleForm()
    {
        $session = session('srta-kindle-identifier');
        if ( !empty($session) && Cubicle::where('identifier', $session)->exists()) return redirect(route('kindle-dashboard', $session));

        $uuid = Str::uuid();

        $activeExam = Exam::where('status', 1)->first();

        if ( empty($activeExam) ) return redirect(route('login'))->with('error', 'No active exam found!');

        return view('register-kindle', compact('activeExam', 'uuid'));
    }

    public function registerKindle(Request $request)
    {
        $request->validate([
            'cubicle_number' => 'required|integer'
        ]);

        $activeExam = Exam::where('status', 1)->first();

        if ( empty($activeExam) ) return redirect(route('login'))->with('error', 'No active exam found!');

        $cubicle = Cubicle::where('cubicle_number', $request->cubicle_number)->first();

        if ( !empty($cubicle) ) {
            $cubicle->update([
                'identifier' => $request->uuid
            ]);

            if ( $cubicle->need_cleanup ) return redirect(route('cleanup', $cubicle->id))->with('success', 'Old kindle reset and new registered.');

            return redirect(route('kindle-dashboard', $request->uuid))->with('success', 'Old kindle reset and new registered.');
        }
        else {
            Cubicle::create([
                'exam_id' => $activeExam->id,
                'cubicle_number' => $request->cubicle_number,
                'identifier' => $request->uuid,
                'has_kindle' => 1
            ]);

            return redirect(route('kindle-dashboard', $request->uuid))->with('success', 'New kindle registered.');
        }
    }

    public function registerKindleCheck($cubicleNumber)
    {
        return response()->json(['exists' => Cubicle::where('cubicle_number', $cubicleNumber)->exists()]);
    }

    public function kindleDashboard($uuid)
    {
        session(['srta-kindle-identifier' => $uuid]);
        // cookie('srta-kindle-identifier', $uuid);
        $cubicle = Cubicle::where('identifier', $uuid)->firstOrFail();

        return view('evaluator-login', compact('cubicle', 'uuid'));
    }

    public function cleanupDone(Cubicle $cubicle)
    {
        $cubicle->update(['need_cleanup' => 0]);

        CleanedUp::dispatch($cubicle->id);

        return redirect(route('kindle-dashboard', $cubicle->identifier))->with('success', 'Operatory cleaned up!');
    }

    public function cleanUpPage(Cubicle $cubicle)
    {
        return view('cleanup', compact('cubicle'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\NameService;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role_id', '!=', 1)->with('role')->get();

        return view('users.index', compact('users'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('id', '!=', 1)->get();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $password = $this->generatePassword($request->first_name, $request->last_name, $request->phone);
        $request->merge(['password' => bcrypt($password), 'name' => $request->first_name.' '.$request->last_name]);

        User::create($request->all());

        return redirect(route('users.index'))->with('success', 'Data saved.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, NameService $nameService)
    {
        $roles = Role::where('id', '!=', 1)->get();

        $name = $nameService->breakdownName($user->name);

        return view('users.edit', compact('user', 'name', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $password = $this->generatePassword($request->first_name, $request->last_name, $request->phone);
        $request->merge(['password' => bcrypt($password), 'name' => $request->first_name.' '.$request->last_name]);

        $user->update($request->all());

        return redirect(route('users.index'))->with('success', 'Data updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect(route('users.index'))->with('success', 'Data deleted.');
    }

    public function multiuserLogin($id)
    {
        $user = User::findOrFail($id);
        Cookie::queue('current_role', auth()->user()->role_id, 60); // 60 minutes, adjust as needed
        Cookie::queue('current_user_id', auth()->user()->id, 60);

        if ($user) {
            Auth::logout();
            Auth::loginUsingId($id);

            switch (auth()->user()->role_id) {
                case 2:
                    return redirect()->intended(route('evaluator-dashboard'));
                    break;

                case 3:
                    return redirect()->intended(route('assistant-dashboard'));
                    break;

                case 4:
                    return redirect()->intended(route('invigilator-dashboard'));
                    break;

                default:
                    return redirect()->intended(route('manager-dashboard'));
                    break;
            }
        }

    }

    public function backToPreviousDashboard()
    {

        if (Cookie::has('current_role') && Cookie::has('current_user_id')) {
            $currentRole = Cookie::get('current_role');
            $currentUserId = Cookie::get('current_user_id');


            if ($currentRole && $currentUserId) {
                Auth::logout();
                Auth::loginUsingId($currentUserId);
                Cookie::queue(Cookie::forget('current_role'));
                Cookie::queue(Cookie::forget('current_user_id'));

                // Redirect to the previous dashboard based on the current role
                switch ($currentRole) {
                    case 1:
                        return redirect()->route('dashboard');
                        break;

                    case 2:
                        return redirect()->route('evaluator-dashboard');
                        break;

                    case 3:
                        return redirect()->route('assistant-dashboard');
                        break;

                    case 4:
                        return redirect()->route('invigilator-dashboard');
                        break;

                    default:
                        return redirect()->route('manager-dashboard');
                        break;
                }
            }
        }



        // // Handle the case when there are no valid cookies or user is not allowed to go back to the previous dashboard.
        // // You can redirect them to a specific page or show an error message.
        // return redirect()->route('assistant-dashboard'); // Redirect to the default dashboard or customize as needed.
    }





    // public function backToAdminDashboard()
    // {
    //     $originalRole = session('original_role');

    //     if ($originalRole === 1) {
    //         Auth::logout();
    //         Auth::loginUsingId($originalRole);
    //         return redirect()->intended(route('dashboard'));
    //     }

    //     // Handle the case when there's no valid data in the session or the user is not allowed to go back to the admin dashboard.
    //     // You can redirect them to a specific page or show an error message.
    //     return redirect()->route('assistant-dashboard'); // Redirect to the default dashboard or customize as needed.
    // }














    private function generatePassword($firstname, $lastname, $phone)
    {
        $initials['first'] = substr($firstname, 0, 1);
        $initials['second'] = substr($lastname, 0, 1);
        $lastFourDigits = substr($phone, -4);

        return $initials['first'].$initials['second'].$lastFourDigits;
    }





}

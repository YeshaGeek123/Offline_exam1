@extends('layouts.guest')

@section('content')    
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="card" style="border: 1px solid #eee; margin-top: 22vh; background-color: ghostwhite;">
                    <div class="card-heading" style="background-color: ghostwhite;">
                        <h3 class="box-title mb-0">Sign In</h3>
                    </div>
                    <div class="card-body">
                        
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                
                        <form class="form-horizontal form-material" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="example-email" class="col-md-12 p-0">Email/Username</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" placeholder="Enter email or username"
                                        class="form-control p-0 border-0"
                                        id="example-email" name="email" required>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Password</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="password" placeholder="Enter password" class="form-control p-0 border-0" name="password" required>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="col-sm-12">
                                    <label for="remember_me" class="inline-flex items-center">
                                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 align-middle" name="remember">
                                        <span class="ml-2 text-sm align-middle">Remember me</span>
                                    </label>
                                </div>
                            </div>
                            <div class="flex">
                                <button type="submit" class="btn btn-success">Login</button>
                                <a class="text-underline text-sm float-end" href="{{ route('register-kindle') }}">Register a kindle</a>
                                {{-- @if (Route::has('password.request'))
                                    <a class="text-underline text-sm float-end" href="{{ route('password.request') }}">Forgot your password?</a>
                                @endif --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
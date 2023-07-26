@extends('layouts.guest')

@section('content')    
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="card" style="border: 1px solid #eee; margin-top: 22vh;">
                    <div class="card-heading" style="background-color: ghostwhite;">
                        <h3 class="box-title mb-0">Forgot Password</h3>
                    </div>
                    <div class="card-body" style="background-color: ghostwhite;">
                        
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                
                        <form class="form-horizontal form-material" method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="example-email" class="col-md-12 p-0">Email</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="email" placeholder="Enter your email"
                                        class="form-control p-0 border-0"
                                        id="example-email" name="email" required>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="col-sm-12 text-secondary">
                                    <em>Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</em>
                                </div>
                            </div>
                            <div class="flex">
                                <button type="submit" class="btn btn-success">Email Password Reset Link</button>

                                <a class="btn btn-warning" href="{{ route('login') }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
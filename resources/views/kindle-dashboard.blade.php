@extends('layouts.guest')

@section('content')    
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="card" style="border: 1px solid #eee; margin-top: 22vh; background-color: ghostwhite;">
                    <div class="card-heading" style="background-color: ghostwhite;">
                        <h3 class="box-title mb-0">Operatory: {{ $cubicle->cubicle_number }}</h3>
                    </div>
                    <div class="card-body">
                        
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                
                        {{-- <form class="form-horizontal form-material" method="POST" action="{{ route('student-login') }}">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="example-email" class="col-md-12 p-0">Student Code</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" placeholder="Enter student code" class="form-control p-0 border-0" name="code" required>
                                </div>
                            </div>
                            <div class="flex">
                                <button type="submit" class="btn btn-success">Login</button>
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
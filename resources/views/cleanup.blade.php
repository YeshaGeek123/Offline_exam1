@extends('layouts.guest')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="card" style="border: 1px solid #eee; margin-top: 22vh; background-color: ghostwhite;">
                    <div class="card-heading" style="background-color: ghostwhite;">
                        <h3 class="box-title mb-0"> Sign In ( <span class="text-danger">Operatory: {{ $cubicle->cubicle_number }}</span> )</h3>
                    </div>
                    <div class="card-body">

                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                        <form class="form-horizontal form-material" method="POST" action="{{ route('cleanup-done', $cubicle->id) }}">
                            @csrf

                            <div class="flex">
                                <a href="{{ route('cleanup-done', $cubicle->id) }}" class="btn btn-info btn-lg"><i class="fa fa-check"></i> Cleanup</a>
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

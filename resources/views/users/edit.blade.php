@extends('layouts.app')

@section('nav-users', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Users</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="{{ route('users.index') }}" class="fw-normal">Users</a></li>
                        <li>&nbsp; <i class="fas fa-chevron-right"></i> <a href="javascript:;" class="fw-bold"> Create User</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="col-lg-8 col-xlg-9 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material" method="POST" action="{{ route('users.update', $user->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">First Name <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" class="form-control p-0 border-0" name="first_name" placeholder="Enter first name" value="{{ $name['first_name'] }}" required> 
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Last Name <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" class="form-control p-0 border-0" name="last_name" placeholder="Enter last name" value="{{ $name['last_name'] }}" required> 
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Username <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="text" class="form-control p-0 border-0" name="username" placeholder="Enter username" value="{{ $user->username }}" required> 
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Email <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="email" class="form-control p-0 border-0" name="email" placeholder="Enter email" value="{{ $user->email }}" required> 
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Phone <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="number" class="form-control p-0 border-0" name="phone" placeholder="Enter phone" value="{{ $user->phone }}" required> 
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-sm-12">Role <span class="text-danger">*</span></label>

                                <div class="col-sm-12 border-bottom">
                                    <select class="form-select shadow-none p-0 border-0 form-control-line" name="role_id">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group mb-4">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">Save</button>
                                    <a class="btn btn-warning" href="{{ route('users.index') }}">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
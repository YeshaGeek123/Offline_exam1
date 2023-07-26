@extends('layouts.app')

@section('nav-termination', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Termination</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Termination</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title">Terminate Student</h3>

                    <form action="{{ route('assistant-termination') }}" method="POST">
                        @csrf

                        <div class="form-group row mb-3">
                            <div class="col-2">
                                <label for="" class="col-form-label">Student Code: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-10">
                                <input type="text" name="student_code" class="form-control" placeholder="Enter student code" required>
                            </div>
                        </div>
                        
                        <div class="form-group row mb-3">
                            <div class="col-2">
                                <label for="" class="col-form-label">Reason for termination: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-10">
                                <textarea name="reason" id="" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Terminate</button>
                    </form>
                    
                    {{-- <notification-table :unreads="{{ auth()->user()->unreadNotifications }}" :notifications="{{ auth()->user()->notifications()->get() }}" :user="{{ auth()->id() }}"></notification-table> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready( function () {

        } );
    </script>
@endpush
@extends('layouts.app')

@section('nav-exams', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Exams</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="{{ route('exams.index') }}" class="fw-normal">Exams</a></li>
                        <li>&nbsp; <i class="fas fa-chevron-right"></i> <a href="javascript:;" class="fw-bold"> Create Exam</a></li>
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
                        <form class="form-horizontal form-material" method="POST" action="{{ route('exams.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            {{-- <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Cubicles <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <select class="select2 w-100" name="cubicles[]" multiple required>
                                        @foreach ($cubicles as $c)
                                            <option value="{{ $c->id }}">{{ $c->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            
                            <div class="mb-4">
                                <label class="form-label">Exam Excel File <span class="text-danger">*</span></label>
                                <input type="file" accept=".xlsx" class="form-control" name="examinput" required> 
                            </div>
                            
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Evaluators <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <select id="select-evaluators" class="select2 w-100" name="evaluators[]" multiple required>
                                        @foreach ($users as $u)
                                            @if ($u->role_id == 2)
                                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Assistants <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <select class="select2 w-100" name="assistants[]" multiple required>
                                        @foreach ($users as $u)
                                            @if ($u->role_id == 3)
                                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Invigilators <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <select class="select2 w-100" name="invigilators[]" multiple required>
                                        @foreach ($users as $u)
                                            @if ($u->role_id == 4)
                                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Manager <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <select class="select2 w-100" name="manager" required>
                                        <option value="" selected disabled></option>
                                        @foreach ($users as $u)
                                            @if ($u->role_id == 5)
                                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            {{-- <div class="mb-4">
                                <label class="form-label">Evaluator Questionaire File <span class="text-danger">*</span></label>
                                <input type="file" accept=".xlsx" class="form-control" name="questionsinput" required> 
                            </div> --}}
                            
                            <div class="form-group mb-4">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">Save</button>
                                    <a class="btn btn-warning" href="{{ route('exams.index') }}">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        .select2-container--default .select2-selection--multiple:before {
            content: ' ';
            display: block;
            position: absolute;
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            right: 6px;
            margin-left: -4px;
            margin-top: -2px;top: 50%;
            width: 0;cursor: pointer
        }

        .select2-container--open .select2-selection--multiple:before {
            content: ' ';
            display: block;
            position: absolute;
            border-color: transparent transparent #888 transparent;
            border-width: 0 4px 5px 4px;
            height: 0;
            right: 6px;
            margin-left: -4px;
            margin-top: -2px;top: 50%;
            width: 0;cursor: pointer
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
            
            $('form').on('submit', function(){
                var minimum = 3;
    
                if($("#select-evaluators").select2('data').length >= minimum)
                    return true;
                else 
                    alert('Please select at least 3 evaluators');
                    return false;
            });
        });

    </script>
@endpush
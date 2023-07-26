@extends('layouts.app')

@section('nav-dashboard', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Dashboard</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        @if (Cookie::has('current_role') && Cookie::has('current_user_id'))
                            <a href="{{ route('back-to-previous-dashboard') }}">Back to Previous Dashboard</a>
                        @endif
                        @if(auth()->user()->role_id === 1 && session('original_role') === 1)
                        <a href="{{ route('back-to-admin-dashboard') }}">Back to Admin Dashboard</a>
                        @endif
                        <li><a href="#" class="fw-normal">Dashboard</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title">Assign to operatory / waiting room</h3>

                    <form action="{{ route('assistant-assign-to-cubicle') }}" method="POST">
                        @csrf

                        <div class="form-group row mt-3">
                            <div class="col-2">
                                <label for="" class="col-form-label">Assign To: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="radio-cubicle" value="1" checked>
                                    <label class="form-check-label" for="radio-cubicle">
                                        Operatory
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="radio-waiting" value="2">
                                    <label class="form-check-label" for="radio-waiting">
                                        Waiting Room
                                    </label>
                                </div>
                            </div>
                            {{-- <label for="" class="col-2 col-form-label">Cubicle: <span class="text-danger">*</span></label> --}}
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-2">
                                <label for="" class="col-form-label">Student Code: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-10">
                                {{-- <input type="text" name="student_code" class="form-control" placeholder="Enter student code" required> --}}
                                <select name="student_code" id="student_code" class="form-control" required>
                                    <option value="" selected disabled>Select a student...</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->sequence_number }}">{{ $student->sequence_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="cubicle">
                            <div class="form-group row mb-3">
                                <label for="" class="col-2 col-form-label">Operatory: <span class="text-danger">*</span></label>
                                <div class="col-10">
                                    <select name="cubicle_id" id="cubicle_id" class="form-control" required>
                                        <option value="" selected disabled>Select an operatory...</option>
                                        @foreach ($activeExam->cubicles as $cubicle)
                                            <option value="{{ $cubicle->id }}">{{ $cubicle->cubicle_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="" class="col-2 col-form-label">Section: <span class="text-danger">*</span></label>
                                <div class="col-10">
                                    <select name="section_id" id="section_id" class="form-control" required>
                                        <option value="" selected disabled>Select a section...</option>
                                        @foreach ($activeExam->sections as $section)
                                            <option value="{{ $section->id }}">{{ $section->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="form-group row mb-3">
                                <label for="" class="col-2 col-form-label">Procedure: <span class="text-danger">*</span></label>
                                <div class="col-10">
                                    <select name="procedure_id" id="procedure_id" class="form-control" required>
                                        <option value="" selected disabled>Select a procedure...</option>
                                    </select>
                                </div>
                            </div> --}}
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                    {{-- <notification-table :unreads="{{ auth()->user()->unreadNotifications }}" :notifications="{{ auth()->user()->notifications()->get() }}" :user="{{ auth()->id() }}"></notification-table> --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title">Reset operatory</h3>

                    <form action="{{ route('assistant-reset-cubicle') }}" id="resetForm" method="POST">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="" class="col-2 col-form-label">Operatory: <span class="text-danger">*</span></label>
                            <div class="col-10">
                                <select name="cubicle_id" id="cubicle_id" class="form-control" required>
                                    <option value="" selected disabled>Select an operatory...</option>
                                    @foreach ($activeExam->cubicles as $cubicle)
                                        <option value="{{ $cubicle->id }}">{{ $cubicle->cubicle_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="button" id="reset-btn" class="btn btn-primary">Reset</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title">Cleanup operatory</h3>

                    <div class="form-group row mb-3">
                        <label for="" class="col-2 col-form-label">Operatory: <span class="text-danger">*</span></label>
                        <div class="col-10">
                            <select name="cubicle_id" id="cleaup-select" class="form-control" required>
                                <option value="" selected disabled>Select an operatory...</option>
                                @foreach ($activeExam->cubicles as $cubicle)
                                    <option value="{{ $cubicle->id }}">{{ $cubicle->cubicle_number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <a href="#" id="cleanup-btn" class="btn btn-primary">Cleanup</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#cleaup-select').on('change', function() {
                var selectedVal = $(this).val();

                $('#cleanup-btn').attr('href', '/cleanup-done/' + selectedVal);
            });

            $('#cleanup-btn').on('click', function() {
                if ( $('#cleaup-select').val() == null ) {
                    toastr.error('Please select an operatory first!');

                    return false;
                }
            });

            $('#radio-cubicle').on('click', function() {
                $('#cubicle').show();
                $('#cubicle_id,#section_id,#procedure_id').attr('required', true);
            });

            $('#radio-waiting').on('click', function() {
                $('#cubicle').hide();
                $('#cubicle_id,#section_id,#procedure_id').attr('required', false);
            });

            $('#section_id').on('change', function() {
                var selectedId = $(this).val();
                var procedure = $('#procedure_id');

                $.ajax({
                    url: `/get-all-related-procedures/${selectedId}`,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        if ( response.procedures != "" ) {
                            procedure.html('');
                            procedure.append(`<option selected disabled>Select a procedure...</option>`);

                            $.each(response.procedures, function( index, value ) {
                                procedure.append(`<option value=${value.id}>${value.title}</option>`);
                            });
                        }
                        else {
                            toastr.error('No procedures found.');
                        }
                    }
                });
            });

            $('#reset-btn').on('click', function() {
                if (confirm("Are you sure you want to reset this cubicle?") == true) {
                    $('#resetForm').submit();
                }
            });
        });
    </script>
@endpush

@extends('layouts.app')

@section('nav-waiting', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Waiting Room</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Waiting Room</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table class="table text-nowrap display" id="srta-table">
                            <thead>
                                <tr>
                                    <th class="border-top-0">#</th>
                                    <th class="border-top-0">Student</th>
                                    <th class="border-top-0">Time</th>
                                    <th class="border-top-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->student->sequence_number }}</td>
                                        <td>{{ date('Y/m/d g:i a', strtotime($student->created_at)) }}</td>
                                        <td>
                                            <button data-id="{{ $student->id }}" type="button" class="btn btn-sm btn-info btn-rounded assign-btn" title="Assign to cubicle / waiting room"><i class="fa fa-share-square "></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel">Assign to operatory / waiting room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('assistant-assign-to-cubicle-from-waiting-room') }}" id="assignForm" method="POST">
                        @csrf

                        <input type="hidden" id="student_id" name="student_id">
                        <div class="form-group mb-3">
                            <label for="">Operatory: <span class="text-danger">*</span></label>
                                <select name="cubicle_id" id="cubicle_id" class="form-control" required>
                                    <option value="" selected disabled>Select a operatory...</option>
                                    @foreach ($activeExam->cubicles as $cubicle)
                                        <option value="{{ $cubicle->id }}">{{ $cubicle->cubicle_number }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Section: <span class="text-danger">*</span></label>
                                <select name="section_id" id="section_id" class="form-control" required>
                                    <option value="" selected disabled>Select a section...</option>
                                    @foreach ($activeExam->sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->title }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Procedure: <span class="text-danger">*</span></label>
                                <select name="procedure_id" id="procedure_id" class="form-control" required>
                                    <option value="" selected disabled>Select a procedure...</option>
                                </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="assignForm" class="btn btn-primary">Assign</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css"/>
@endpush

@push('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#srta-table').DataTable({
                responsive: true,
                order: [[ 2, "desc" ]],
                columnDefs: [
                    {
                        targets: -1,
                        orderable: false
                    }
                ]
            });

            $('.assign-btn').on('click', function() {
                var selectedId = $(this).data('id');

                $('#student_id').val(selectedId);
                $('#assignModal').modal('show');
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
        } );
    </script>
@endpush
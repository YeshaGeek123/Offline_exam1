@extends('layouts.app')

@section('nav-dashboard', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">{{ $exam->title }} [ {{ $exam->code }} ]</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="{{ route('invigilator-dashboard') }}" class="fw-normal">Dashboard</a></li>
                        <li>&nbsp; <i class="fas fa-chevron-right"></i> <a href="javascript:;" class="fw-bold"> Students List</a></li>
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
                                    <th class="border-top-0">Name</th>
                                    <th class="border-top-0">Code</th>
                                    <th class="border-top-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->code }}</td>
                                        <td>
                                            <input type="radio" class="form-check-input present-btn" id="show{{ $student->id }}" name="is_present_{{ $student->id }}" value="1" data-id="{{ $student->id }}" {{ $student->is_present == 1 ? 'checked' : '' }}> <label for="show{{ $student->id }}" class="form-check-label">Show</label> &nbsp;
                                            <input type="radio" class="form-check-input present-btn" id="noshow{{ $student->id }}" name="is_present_{{ $student->id }}" value="0" data-id="{{ $student->id }}" {{ $student->is_present == 0 ? 'checked' : '' }}> <label for="noshow{{ $student->id }}" class="form-check-label">No show</label> 
                                            {{-- @if (empty($student->is_present))
                                                <a href="#" data-id="{{ $student->id }}" class="btn btn-sm btn-info btn-rounded present-btn" title="Mark as present"><i class="fas fa-check"></i> Mark Present</a>
                                            @else
                                                <a href="#" data-id="{{ $student->id }}" class="btn btn-sm btn-success btn-rounded present-btn disabled" title="Mark as present"><i class="fas fa-check"></i> Present</a>
                                            @endif --}}
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
                order: [[ 0, "asc" ]],
                columnDefs: [
                    {
                        targets: -1,
                        orderable: false
                    }
                ]
            });

            $(document).on('click', '.present-btn', function(e) {
                let el = $(this);
                let selectedId = $(this).data('id'); 
                let selectedValue = $(this).val(); 

                $.ajax({
                    url: '/invigilator/mark-present/' + selectedId + '/' + selectedValue,
                    type: 'GET',
                    dataType: 'json'
                });
            });
        } );
    </script>
@endpush
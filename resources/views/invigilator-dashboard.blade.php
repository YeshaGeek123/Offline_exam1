@extends('layouts.app')

@section('nav-dashboard', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Exams</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Dashboard</a></li>
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
                                    <th class="border-top-0">Title</th>
                                    <th class="border-top-0">Code</th>
                                    <th class="border-top-0">Date</th>
                                    <th class="border-top-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exams as $exam)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $exam->title }}</td>
                                        <td>{{ $exam->code }}</td>
                                        <td>{{ date('Y/m/d g:i a', strtotime($exam->exam_start)) . ' - ' . date('Y/m/d g:i a', strtotime($exam->exam_end)) }}</td>
                                        <td>
                                            <a href="{{ route('invigilator-student-list', $exam->id) }}" class="btn btn-sm btn-info btn-rounded" title="View students"><i class="fas fa-eye"></i></a>
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
        } );
    </script>
@endpush
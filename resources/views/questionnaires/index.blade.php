@extends('layouts.app')

@section('nav-questionnaires', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Questionnaires</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Questionnaires</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-sm-12">
                <a href="{{ route('questionnaires.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> &nbsp; Create New Questionnaire</a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table class="table text-nowrap display responsive " id="srta-table" width="100%">
                            <thead>
                                <tr>
                                    <th class="border-top-0">#</th>
                                    <th class="border-top-0">Exam Type</th>
                                    <th class="border-top-0">Section</th>
                                    <th class="border-top-0">Procedure</th>
                                    <th class="border-top-0">Category</th>
                                    <th class="border-top-0">Title</th>
                                    <th class="border-top-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questionnaires as $q)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $q->exam_type->title }}</td>
                                        <td>{{ $q->section->title }}</td>
                                        <td>{{ $q->procedure->title }}</td>
                                        <td>{{ $q->category->title }}</td>
                                        <td>{{ $q->title }}</td>
                                        <td>
                                            <a href="{{ route('questionnaires.show', $q->id) }}" class="btn btn-sm btn-secondary btn-rounded" title="View details"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('questionnaires.edit', $q->id) }}" class="btn btn-sm btn-info btn-rounded" title="Edit details"><i class="fa fa-edit"></i></a>
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
            var table = $('#srta-table').DataTable({
                responsive: true,
                order: [[ 0, "asc" ]],
                columnDefs: [
                    {
                        targets: -1,
                        orderable: false
                    },
                    {
                        targets: -2,
                        serarchable: false,
                        orderable: false
                    }
                ]
            });

            $(document).on('click', '.change-status', function(e) {
                e.preventDefault();

                let selectedId = $(this).data('id'); 
                let selectedStatus = $(this).data('status'); 

                let link = `/questionnaires/toggle-status/${selectedId}/${selectedStatus}`;
                let message = "Do you really want to toggle exam status?";
                let header = "Toggle status";

                makeModal(link, message, header, "GET"); 
            });
        } );
    </script>
@endpush
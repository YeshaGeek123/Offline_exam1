@extends('layouts.app')

@section('nav-categories', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Categories</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="#" class="fw-normal">Categories</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-sm-12">
                <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> &nbsp; Create New Category</a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table class="table text-nowrap display" id="srta-table">
                            <thead>
                                <tr>
                                    <th class="border-top-0">#</th>
                                    <th class="border-top-0">Name</th>
                                    <th class="border-top-0">Section</th>
                                    <th class="border-top-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->title }}</td>
                                        <td>{{ $category->pro_title }}</td>
                                        <td>
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-info btn-rounded" title="Edit details"><i class="fa fa-edit"></i></a>
                                            <a href="#" data-id="{{$category->id}}" class="btn btn-sm btn-danger btn-rounded del-btn" title="Delete"><i class="fa fa-trash"></i></a>
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

            $(document).on('click', '.del-btn', function(e) {
                e.preventDefault();

                let selectedId = $(this).data('id'); 
                let link = `/categories/${selectedId}`;
                let message = "Do you really want to delete this category?";
                let header = "Delete category";

                makeModal(link, message, header, "DELETE"); 
            });
        } );
    </script>
@endpush
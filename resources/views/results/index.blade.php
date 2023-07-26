@extends('layouts.app')

@section('nav-results', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Results</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="{{ route('dashboard') }}" class="fw-normal">Dashboard</a></li>
                        <li>&nbsp; <i class="fas fa-chevron-right"></i> <a href="javascript:;" class="fw-bold"> Results</a></li>
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
                                    <th class="border-top-0">Exam</th>
                                    <th class="border-top-0">Evaluator</th>
                                    <th class="border-top-0">Student</th>
                                    <th class="border-top-0">Full Marks</th>
                                    <th class="border-top-0">Obtained Marks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($newData))
                                    @foreach ($newData as $nd)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $nd['exam'] }}</td>
                                            <td>{{ $nd['evaluator'] }}</td>
                                            <td>{{ $nd['student'] }}</td>
                                            <td>{{ $nd['full_marks'] }}</td>
                                            <td>{{ $nd['obtained_marks'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
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
                // columnDefs: [
                //     {
                //         targets: -1,
                //         orderable: false
                //     }
                // ]
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
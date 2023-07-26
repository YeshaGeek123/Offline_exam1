@extends('layouts.app')

@section('nav-exams', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="{{ route('exams.index') }}" class="fw-normal">Exams</a></li>
                        <li>&nbsp; <i class="fas fa-chevron-right"></i> <a href="{{ route('exams.show', $student->exam_id) }}" class="fw-bold"> View Exam Details</a></li>
                        <li>&nbsp; <i class="fas fa-chevron-right"></i> <a href="javascript:;" class="fw-bold"> View Student Details</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid content-row">
        <div class="row">
            <div class="col-sm-12">
                <div class="card "> 
                    <div class="card-body">
                        <h3 class="box-title">Student Details</h3>
                        <p><strong>Name:</strong> {{ $student->name }}</p>
                        <p><strong>Sequence Number:</strong> {{ $student->sequence_number }}</p>
                        <p><strong>Email:</strong> {{ $student->email }}</p>
                        <p><strong>Address:</strong> {{ $student->address }}</p>
                        <p><strong>Phone:</strong> {{ $student->phone }}</p>
                        <p><strong>Social:</strong> {{ $student->social }}</p>
                        <p><strong>School:</strong> {{ $student->school }}</p>
                        <p><strong>Graduation Date:</strong> {{ $student->graduation_date }}</p>
                        <p><strong>Exam:</strong> {{ $student->exam->code }}</p>
                    </div>
                </div>
            </div>
            @foreach ($student->sections as $section)    
                <div class="col-sm-12 col-lg-6">
                    <div class="card"> 
                        <div class="card-body">
                            <h5>{{ $section->title }}</h5>
                            <table class="table text-nowrap">
                                <thead>
                                    <th>Evaluator</th>
                                    <th>Status</th>
                                    {{-- <th>Action</th> --}}
                                </thead>
                                <tbody>
                                    @php
                                        $evaluations = \App\Models\NewEvaluation::where('student_id', $student->id)->where('section_id', $section->id)->get();
                                    @endphp
                                    @foreach ($evaluations as $ev)
                                        <tr>
                                            <td>{{ $ev->user->name }}</td>
                                            <td>
                                                @switch($ev->status)
                                                    @case(2)
                                                        <span class="text-success">Pass</span>
                                                        @break

                                                    @case(3)
                                                        <a href="#" class="view-fail" data-id="{{ $ev->id }}"><span class="text-danger text-decoration-underline">Fail</span></a>
                                                        @break

                                                    @default
                                                        <span class="text-warning">Ongoing</span>
                                                        
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="failModal" tabindex="-1" aria-labelledby="failModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="failModalLabel">Failed Criterias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="failModalBody">
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('.view-fail').on('click', function() {
                var selectedId = $(this).data('id');
                var html = '';

                $.ajax({
                    url: '/get-failed-criterias/' + selectedId,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        if ( response.criterias != '' || response.criterias != [] ) {
                            
                            $.each(response.criterias, function(qid, criterias) {
                                html += `
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                ${criterias[0].questionnaire.title}
                                            </div>
                                            <div class="card-body">
                                                <div class="col-12">
                                                    <div class="bg-danger text-white p-3">
                                `;
                                $.each(criterias, function(i, c) {
                                    html += `
                                        <label for="" class="inline-flex items-center">
                                            <i class="fa fa-times" style="vertical-align: middle;"></i> &nbsp;
                                            <span class="ml-2 text-sm align-middle">${c.title}</span>
                                        </label> 
                                        <br>
                                    `;       
                                });

                                html += `
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });

                            $('#failModalBody').html(html);
                            $('#failModal').modal('show');
                        }
                    }
                });
            });
        });
    </script>
@endpush
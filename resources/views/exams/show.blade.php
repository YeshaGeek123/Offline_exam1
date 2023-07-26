@extends('layouts.app')

@section('nav-exams', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">{{ $exam->title }} [ {{ $exam->code }} ]</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="{{ route('exams.index') }}" class="fw-normal">Exams</a></li>
                        <li>&nbsp; <i class="fas fa-chevron-right"></i> <a href="javascript:;" class="fw-bold"> View Exam Details</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid content-row">
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="card "> <div class="card-body">
                    <h3 class="box-title">Exam Details</h3>
                    <p><strong>Exam Code:</strong> {{ $exam->code }}</p>
                    <p><strong>Exam Date:</strong> {{ date('Y/m/d g:i a', strtotime($exam->exam_start)) }} - {{ date('Y/m/d g:i a', strtotime($exam->exam_end)) }}</p>
                    <p><strong>Type:</strong> {{ $exam->type }}</p>
                    <p><strong>Facility:</strong> {{ $exam->facility_name }}</p>
                    <p><strong>State:</strong> {{ $exam->state }}</p>
                    <p><strong>ZIP:</strong> {{ $exam->zip }}</p>
                    <p><strong>Address:</strong> {{ $exam->address }}</p>
                    <p><strong>Manager:</strong> {{ $exam->users->where('role_id', 5)->first()->name }}</p>
                </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="card "> <div class="card-body">
                    <h3 class="box-title">Sections & Groups</h3>
                    
                    <div class="accordion" id="accordionExample">
                        @foreach ($exam->sections as $key => $section)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapse{{ $key }}">
                                        {{ $section->title }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $key }}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul>
                                            @foreach (\App\Models\Group::where('exam_section_id', $section->pivot->id)->get() as $group)
                                                <li>{{ $group->title }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-4">
                <div class="card"> <div class="card-body">
                    <div class="table-responsive">    
                        <h5>Evaluators</h5>
                        <table class="table text-nowrap">
                            
                            <tbody>
                                @foreach ($exam->users->where('role_id', 2) as $ev)
                                    <tr>
                                        <td>{{ $ev->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                    {{-- <evaluator-table :evaluators="{{ $exam->users->where('role_id', 2) }}" :examid="{{ $exam->id }}"></evaluator-table> --}}
                </div>
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="card"> <div class="card-body">
                    <div class="table-responsive">    
                        <h5>Assistants</h5>
                        <table class="table text-nowrap">
                            
                            <tbody>
                                @foreach ($exam->users->where('role_id', 3) as $as)
                                    <tr>
                                        <td>{{ $as->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="card"> <div class="card-body">
                    <div class="table-responsive">    
                        <h5>Invigilators</h5>
                        <table class="table text-nowrap">
                            
                            <tbody>
                                @foreach ($exam->users->where('role_id', 4) as $as)
                                    <tr>
                                        <td>{{ $as->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card"> <div class="card-body">
                    {{-- <div class="row mb-4">
                        <div class="col-sm-12">
                            <a href="{{ route('students.create', $exam->id) }}" class="btn btn-primary"><i class="fa fa-plus"></i> &nbsp; Add Student</a>
                        </div>
                    </div> --}}
                    <div class="table-responsive">
                        <table class="table text-nowrap display responsive" id="srta-table">
                            <thead>
                                <tr>
                                    <th class="border-top-0">#</th>
                                    <th class="border-top-0">Sequence No.</th>
                                    <th class="border-top-0">Name</th>
                                    <th class="border-top-0">Email</th>
                                    <th class="border-top-0">Address</th>
                                    <th class="border-top-0">Social</th>
                                    <th class="border-top-0">Graduation</th>
                                    <th class="border-top-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exam->students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->sequence_number }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->address }}</td>
                                        <td>{{ $student->social }}</td>
                                        <td>{{ $student->graduation_date }}</td>
                                        <td>
                                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-primary btn-rounded" title="Edit details"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-info btn-rounded" title="Edit details"><i class="fa fa-edit"></i></a>
                                            <a href="#" data-id="{{$student->id}}" class="btn btn-sm btn-danger btn-rounded del-btn" title="Delete"><i class="fa fa-trash"></i></a>
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
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css"/>

    <style>
        div.card {
            height: calc(100% - 20px);
            margin-bottom: 20px;
        }
    </style>
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
                let link = `/students/${selectedId}`;
                let message = "Do you really want to delete this student?";
                let header = "Delete student";

                makeModal(link, message, header, "DELETE"); 
            });
        } );
    </script>
@endpush
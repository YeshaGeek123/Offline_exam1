@extends('layouts.evaluation')

@section('nav-dashboard', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Student Failure</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="javascript:;" class="fw-bold"> Manager</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Evaluation Details:
                    </div>
                    <div class="card-body">
                        <p><strong>Student Code: <span class="text-info">{{ $student->sequence_number }}</span></strong></p>
                        <p><strong>Exam Code: <span class="text-info">{{ $student->exam->code }}</span></strong></p>
                        <p><strong>Section: <span class="text-info">{{ $evaluations->first()->section->title }}</span></strong></p>
                        <p><strong>Procedure: <span class="text-info">{{ $evaluations->first()->procedure->title }}</span></strong></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($failedCriterias as $questionnaires)
                @foreach ($questionnaires as $questionnaire)
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                {{ $questionnaire[0]['criteria']['questionnaire']['title'] }} <strong class="float-end"> Evaluator: {{ $questionnaire[0]['evaluation']['user']['name'] }}</strong>
                            </div>
                            <div class="card-body">
                                @csrf                            
                                <div class="row gx-4">
                                    <div class="col-12 mb-3">
                                        <div class="p-3 border border-danger">
                                            <h5 class="card-header my-2">Unacceptable</h5>

                                            @foreach ($questionnaire as $criteria)
                                                <label for="" class="inline-flex items-center criterias">
                                                    <i class="fa fa-times" style="vertical-align: middle;"></i> &nbsp;
                                                    <span class="ml-2 text-sm align-middle">{{ $criteria->criteria->title }}</span>
                                                </label> 
                                                <br>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach

            <div class="form-group mb-4">
                <div class="col-sm-12">
                    <form action="{{ route('manager-pass') }}" id="passForm" method="POST">
                        @csrf
                        <input type="hidden" name="cubicle_id" value="{{ $evaluations->first()->cubicle_id }}">
                    </form>

                    <form action="{{ route('manager-reevaluate') }}" id="reevForm" method="POST">
                        @csrf
                        <input type="hidden" name="cubicle_id" value="{{ $evaluations->first()->cubicle_id }}">
                    </form>

                    <button class="btn btn-primary" form="passForm" type="submit">Pass</button> &nbsp;
                    <button class="btn btn-secondary" form="reevForm" type="submit">Re-evaluate</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
        });
    </script>
@endpush
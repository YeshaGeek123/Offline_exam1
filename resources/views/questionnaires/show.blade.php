@extends('layouts.app')

@section('nav-questionnaires', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Questionnaire Details</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="{{ route('questionnaires.index') }}" class="fw-normal">Questionnaires</a></li>
                        <li>&nbsp; <i class="fas fa-chevron-right"></i> <a href="javascript:;" class="fw-bold"> View Questionnaire Details</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid content-row">
        <div class="row">
            <div class="col-12">
                <div class="card "> <div class="card-body">
                    <p><strong>Questionnaire:</strong> {{ $questionnaire->title }}</p>
                    <p><strong>Exam Type:</strong> {{ $questionnaire->exam_type->title }}</p>
                    <p><strong>Section:</strong> {{ $questionnaire->section->title }}</p>
                    <p><strong>Procedure:</strong> {{ $questionnaire->procedure->title }}</p>
                    <p><strong>Category:</strong> {{ $questionnaire->category->title }}</p>
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="card"> <div class="card-body">
                    <div class="table-responsive">    
                        <h5>Acceptable Criterias</h5>
                        <table class="table text-nowrap">
                            
                            <tbody>
                                @foreach ($questionnaire->criterias->where('is_acceptable', 1) as $acr)
                                    <tr>
                                        <td>{{ $acr->title }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                    {{-- <evaluator-table :evaluators="{{ $exam->users->where('role_id', 2) }}" :examid="{{ $exam->id }}"></evaluator-table> --}}
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="card"> <div class="card-body">
                    <div class="table-responsive">    
                        <h5>Unacceptable Criterias</h5>
                        <table class="table text-nowrap">
                            
                            <tbody>
                                @foreach ($questionnaire->criterias->where('is_acceptable', 0) as $ucr)
                                    <tr>
                                        <td>{{ $ucr->title }}</td>
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
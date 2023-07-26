@extends('layouts.app')

@section('nav-dashboard', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Pre Evaluation Form</h4>
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
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="col-sm-12">
                <div class="white-box">
                    <h5></h5>
                    <form method="GET" action="{{ route('evaluator-evaluate-form') }}">

                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Sections:</label>
                            <div class="col-sm-10">
                                <select name="all_section_id" id="" class="form-control" required>
                                    <option value="">Select Section</option>
                                    @foreach ($groups as $grp)
                                        <option value="{{ $grp->section->section_id }}">{{ $grp->section->section->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Begin Evaluation</button>
                        </div>
                    </form>
                    {{-- <submission-table :students="{{$students}}" :user="{{ auth()->id() }}"></submission-table> --}}

                </div>
            </div>
        </div>
    </div>
@endsection

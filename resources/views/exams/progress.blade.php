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
                        <li>&nbsp; <i class="fas fa-chevron-right"></i> <a href="javascript:;" class="fw-bold"> View Exam Progress</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid content-row">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-primary btn-sm btn-rounded" title="Reload" id="reload"><i class="fa fa-redo"></i></button> &nbsp;
                        <span id="demo1" class="demo">00:00:00</span>
                    </div> 
                    <div class="card-body table-responsive" id="load-table-here">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Student</th>
                                    {{-- <th class="text-center">Group</th> --}}
                                    @foreach ($procedures->groupBy('section_id') as $key =>$section)
                                        @foreach ($section as $procedure)
                                            <th class="text-center" style="background-color: {{ $colors[$key] }}; color: #fff">{{ $procedure->title }}</th>
                                        @endforeach
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td class="text-center">{{ $student->sequence_number }}</td>
                                        {{--  class="text-center"></td> --}}
                                        @foreach ($procedures as $procedure)
                                            @if(!in_array($procedure->section_id, $student->sectionids))
                                                <td class="text-center table-secondary">{{ 'N/A' }}</td>
                                            @else
                                                @if ($student->is_terminated)
                                                    <td class="text-center table-danger">{{ 'T' }}</td>
                                                @else
                                                    <td class="text-center table-success">{{ $student->checkResult($procedure->id) }} <span class="small text-secondary">@php $findGroup = $student->groups->firstWhere('section.section_id', $procedure->section_id); echo '( ' . $findGroup->title . ' )'; @endphp</span></td>
                                                @endif
                                            @endif
                                        @endforeach
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

@push('scripts')
    <script src="{{ asset('/js/timer.js') }}"></script>

    <script>
        $(function() {
            $('#demo1').stopwatch().stopwatch('start');
    
            $(document).on('click', '#reload', function() {
                $.ajax({
                    url: '/exams/{{ $exam->id }}/progress-table-ajax',
                    type: 'get',
                    dataType: 'json',
                    beforeSend: function() {
                        $('.preloader').show();
                    },
                    success: function(res) {
                        $('#demo1').stopwatch('reset');
                        $('#load-table-here').html(res.html);
                        $(".preloader").fadeOut();
                    }
                }); 
            });
        });
    </script>
@endpush
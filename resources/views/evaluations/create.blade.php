@extends('layouts.evaluation')

@section('nav-dashboard', true)

@section('content')
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Student Evaluation</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <div class="d-md-flex">
                    <ol class="breadcrumb ms-auto">
                        <li><a href="{{ route('evaluator-dashboard') }}" class="fw-normal">Dashboard</a></li>
                        <li>&nbsp; <i class="fas fa-chevron-right"></i> <a href="javascript:;" class="fw-bold"> Evaluate</a></li>
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
                        <p><strong>Section: <span class="text-info">{{ $evaluation->section->title }}</span></strong></p>
                        <p><strong>Procedure: <span class="text-info">{{ $evaluation->procedure->title }}</span></strong></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form class="form-horizontal form-material" id="ev-form" method="POST" action="{{ route('evaluator-evaluate-submit-fail') }}">
                @foreach ($questionnaires as $questionnaire)
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                {{ $questionnaire->title }}
                            </div>
                            <div class="card-body">
                                @csrf                            
                                <input type="hidden" name="id" value="{{ $evaluation->id }}">
                                <div class="row gx-4">
                                    <div class="col-12 mb-3">
                                        <div data-id="{{ $questionnaire->id }}" data-type="acceptable" class="p-3 custom-select-box csb-{{ $questionnaire->id }} border border-success">
                                            <h5 class="card-header my-2"> Acceptable <i class="fa fa-check"></i></h5>

                                            {{-- @foreach ($questionnaire->criterias as $cr)
                                                @if( $cr->is_acceptable )
                                                    <label for="cr-{{$cr->id}}" class="inline-flex items-center">
                                                        <i class="fa fa-check" style="vertical-align: middle;"></i> &nbsp;
                                                        <span class="ml-2 text-sm align-middle">{{ $cr->title }}</span>
                                                    </label> 
                                                    <br>
                                                @endif
                                            @endforeach --}}
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mb-3">
                                        <div data-id="{{ $questionnaire->id }}" data-type="unacceptable" class="p-3 custom-select-box csb-{{ $questionnaire->id }} border border-danger">
                                            <h5 class="card-header my-2">Unacceptable</h5>

                                            @foreach ($questionnaire->criterias as $cr)
                                                @if( !$cr->is_acceptable )
                                                    <label for="cr-{{$cr->id}}" class="inline-flex items-center criterias">
                                                        <i class="fa fa-times" style="vertical-align: middle;"></i> &nbsp;
                                                        <span class="ml-2 text-sm align-middle">{{ $cr->title }}</span>
                                                    </label> 
                                                    <br>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </form>

            <div class="form-group mb-4">
                <div class="col-sm-12">
                    <button id="btn-pass" type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    @if (request('is_first') == 1)    
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Submission Confirmation</h5>
                    </div>
                    <div class="modal-body">
                        <p><strong>Student Code: <span class="text-info">{{ $student->sequence_number }}</span></strong></p>
                        <p><strong>Exam Code: <span class="text-info">{{ $student->exam->code }}</span></strong></p>
                        <p><strong>Section: <span class="text-info">{{ $evaluation->section->title }}</span></strong></p>
                        <p><strong>Procedure: <span class="text-info">{{ $evaluation->procedure->title }}</span></strong></p>
                    </div>
                    <div class="modal-footer">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            
                            <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();" class="btn btn-secondary">No</a>
                        </form>
                        <button type="button" data-id="{{ $evaluation->id }}" id="confirmBtn" class="btn btn-primary">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="failModal" tabindex="-1" aria-labelledby="failModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="failModalLabel">Failed Criterias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="failModalBody">
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" form="failCriteriaFrom" data-id="{{ $evaluation->id }}" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var failedQuestionnaires = [];

        $(function() {
            var urlParams = new URLSearchParams(window.location.search);

            if ( urlParams.has('is_first') && urlParams.get('is_first') == 1 ) {
                $('#confirmModal').modal('show');
            }

            $('#btn-pass').on('click', function() {
                if ( failedQuestionnaires.length > 0 ) {
                    $.ajax({
                        url: '{{ route("evaluator-failure-criterias") }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            questionnaires: failedQuestionnaires,
                            evaluation_id: '{{ $evaluation->id }}'

                        },
                        dataType: 'json',
                        success: function(res) {
                            $('#failModalBody').html(res.view);
                        }
                    });

                    $('#failModal').modal('show');
                }
                else {
                    if (confirm("Are you sure you want to mark this submission as pass?") == true) {
                        $('#ev-form').attr('action', '/evaluator/evaluate-form-pass');
                        $("input[type=checkbox]").removeAttr('required');

                        $('#ev-form').submit();
                    }
                }

                return false;
            });
            
            $('#btn-fail').on('click', function() {
                var checked = $("input[type=checkbox]:checked").length;

                if(!checked) {
                    toastr.error("You must check at least one unacceptable crietia.");
                    return false;
                }

                if (confirm("Are you sure you want to mark this submission as fail?") == true) {
                    $('#ev-form').submit();
                }

                return false;
            });

            $('.custom-select-box').on('click', function() {
                var el = $(this);
                var selectedId = el.data('id');

                if ( el.data('type') == 'unacceptable' ) {
                    if ( failedQuestionnaires.indexOf(selectedId) === -1 ) failedQuestionnaires.push(selectedId);
                }
                else {
                    const index = failedQuestionnaires.indexOf(selectedId);

                    if (index > -1) {
                        failedQuestionnaires.splice(index, 1);
                    }
                }

                $('.csb-'+selectedId).removeClass('custom-select-box-selected');
                
                el.addClass('custom-select-box-selected');

                console.log(failedQuestionnaires);
            });

            $('#confirmBtn').on('click', function() {
                var selectedId = $(this).data('id');

                $.ajax({
                    url: '/evaluator/confirm-evaluation/' + selectedId,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    success: function(res) {
                        if ( res.result ) {
                            $('#confirmModal').modal('hide');
                        }
                    }
                });
            });

            $(document).on('click', '.cr-chk', function() {
                var selectedId = $(this).data('qid');

                if ( this.checked ) {
                    $('.cr-chk-'+selectedId).removeAttr('required');
                } 
                else {
                    $('.cr-chk-'+selectedId).attr('required', 'required');
                }
            });
        });
        // $(window).on("beforeunload", function(evt) {
        //     evt.returnValue = '';

        //     axios.get('/evaluator/close/{{$student->id}}');

        //     return undefined;
        // });
    </script>
@endpush
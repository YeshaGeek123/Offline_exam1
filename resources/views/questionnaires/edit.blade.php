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
                        <li><a href="{{ route('questionnaires.index') }}" class="fw-normal">Questionnaires</a></li>
                        <li>&nbsp; <i class="fas fa-chevron-right"></i> <a href="javascript:;" class="fw-bold"> Edit Questionnaire</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="col-lg-12 col-xlg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material" method="POST" action="{{ route('questionnaires.update', $questionnaire->id) }}">
                            @csrf
                            @method('PATCH')
                            
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Exam Type <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <select class="select2 w-100" name="exam_type_id" required>
                                        @foreach ($resources['examTypes'] as $et)
                                            <option value="{{ $et->id }}" {{ $questionnaire->exam_type_id == $et->id ? 'selected' : '' }}>{{ $et->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Section <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <select class="select2 w-100" name="section_id" id="section_id" required>
                                        @foreach ($resources['allSections'] as $as)
                                            <option value="{{ $as->id }}" {{ $questionnaire->section_id == $as->id ? 'selected' : '' }}>{{ $as->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Procedures <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <select class="select2 w-100" name="procedure_id" id="procedure_id" required>
                                        @foreach ($resources['procedures'] as $p)
                                            <option value="{{ $p->id }}" {{ $questionnaire->procedure_id == $p->id ? 'selected' : '' }}>{{ $p->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Categories <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <select class="select2 w-100" name="category_id" id="category_id" required>
                                        @foreach ($resources['categories'] as $c)
                                            <option value="{{ $c->id }}" {{ $questionnaire->category_id == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="col-md-12 p-0">Title <span class="text-danger">*</span></label>
                                <div class="col-md-12 border-bottom p-0">
                                    <textarea class="form-control p-0 border-0" name="title">{{ $questionnaire->title }}</textarea>
                                </div>
                            </div>

                            <h5>Criterias<span class="text-danger">*</span></h5>

                            @foreach ($questionnaire->criterias as $k => $cr)
                                <div class="row mb-4 g-3" id="old_criteria_div_{{ $cr->id }}">
                                    <input type="hidden" name="old_criterias[{{$k}}][to_delete]" id="old_criteria_del_{{ $cr->id }}" value="false">
                                    <input type="hidden" name="old_criterias[{{$k}}][id]" value="{{ $cr->id }}">
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="old_criterias[{{$k}}][criteria]" value="{{ $cr->title }}" required>
                                    </div>
                                    <div class="col-2 pl-3 align-self-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input change-status" type="checkbox" name="old_criterias[{{$k}}][is_acceptable]" {{ $cr->is_acceptable ? "checked" : "" }}> Acceptable?
                                        </div>
                                    </div>
                                    <div class="col-2 pl-3 align-self-center">
                                        <button class="btn btn-rounded btn-danger btn-sm old_criteria_del_btn" type="button" data-id="{{ $cr->id }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            @endforeach

                            <div class="repeater">
                                <div data-repeater-list="criterias">
                                    <div class="row mb-4 g-3" data-repeater-item>
                                        <div class="col-8">
                                            <input type="text" class="form-control" name="criteria" required>
                                        </div>
                                        <div class="col-2 pl-3 align-self-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input change-status" type="checkbox" name="is_acceptable"> Acceptable?
                                            </div>
                                        </div>
                                        <div class="col-2 pl-3 align-self-center">
                                            <button class="btn btn-rounded btn-danger btn-sm" data-repeater-delete type="button"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <button class="btn btn-primary btn-rounded btn-sm" data-repeater-create type="button"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            
                            <div class="form-group mb-4">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">Save</button>
                                    <a class="btn btn-warning" href="{{ route('questionnaires.index') }}">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container--default .select2-selection--multiple:before {
            content: ' ';
            display: block;
            position: absolute;
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            right: 6px;
            margin-left: -4px;
            margin-top: -2px;top: 50%;
            width: 0;cursor: pointer
        }

        .select2-container--open .select2-selection--multiple:before {
            content: ' ';
            display: block;
            position: absolute;
            border-color: transparent transparent #888 transparent;
            border-width: 0 4px 5px 4px;
            height: 0;
            right: 6px;
            margin-left: -4px;
            margin-top: -2px;top: 50%;
            width: 0;cursor: pointer
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js" integrity="sha512-foIijUdV0fR0Zew7vmw98E6mOWd9gkGWQBWaoA1EOFAx+pY+N8FmmtIYAVj64R98KeD2wzZh1aHK0JSpKmRH8w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('.old_criteria_del_btn').on('click', function() {
                var selectedId = $(this).data('id');

                if(confirm('Are you sure you want to delete this criteria?')) {
                    $(`#old_criteria_del_${selectedId}`).val('true');
                    $(`#old_criteria_div_${selectedId}`).hide();
                }
            });

            $('.repeater').repeater({
                // (Optional)
                // start with an empty list of repeaters. Set your first (and only)
                // "data-repeater-item" with style="display:none;" and pass the
                // following configuration flag
                initEmpty: true,
                // (Optional)
                // "defaultValues" sets the values of added items.  The keys of
                // defaultValues refer to the value of the input's name attribute.
                // If a default value is not specified for an input, then it will
                // have its value cleared.
                defaultValues: {
                    'text-input': 'foo'
                },
                // (Optional)
                // "show" is called just after an item is added.  The item is hidden
                // at this point.  If a show callback is not given the item will
                // have $(this).show() called on it.
                show: function () {
                    $(this).slideDown();
                },
                // (Optional)
                // "hide" is called when a user clicks on a data-repeater-delete
                // element.  The item is still visible.  "hide" is passed a function
                // as its first argument which will properly remove the item.
                // "hide" allows for a confirmation step, to send a delete request
                // to the server, etc.  If a hide callback is not given the item
                // will be deleted.
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this criteria?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                // (Optional)
                // You can use this if you need to manually re-index the list
                // for example if you are using a drag and drop library to reorder
                // list items.
                ready: function (setIndexes) {
                    // $dragAndDrop.on('drop', setIndexes);
                },
                // (Optional)
                // Removes the delete button from the first list item,
                // defaults to false.
                isFirstItemUndeletable: false
            });

            $('#section_id').on('change', function() {
                var selectedId = $(this).val();
                var procedure = $('#procedure_id');

                $.ajax({
                    url: `/get-all-related-procedures/${selectedId}`,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        if ( response.procedures != "" ) {
                            procedure.html('');
                            procedure.append(`<option selected disabled>Select a procedure...</option>`);

                            $.each(response.procedures, function( index, value ) {
                                procedure.append(`<option value=${value.id}>${value.title}</option>`);
                            });
                        }
                        else {
                            toastr.error('No procedures found.');
                        }
                    }
                });
            });

            $('#procedure_id').on('change', function() {
                var selectedId = $(this).val();
                var category = $('#category_id');

                $.ajax({
                    url: `/get-all-related-categories/${selectedId}`,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        if ( response.categories != "" ) {
                            category.html('');
                            category.append(`<option selected disabled>Select a category...</option>`);

                            $.each(response.categories, function( index, value ) {
                                category.append(`<option value=${value.id}>${value.title}</option>`);
                            });
                        }
                        else {
                            toastr.error('No categories found.');
                        }
                    }
                });
            });
        });
    </script>
@endpush
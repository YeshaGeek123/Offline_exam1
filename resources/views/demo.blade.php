@extends('layouts.evaluation')

@section('content')
        <button id="submit-button" type="button">
            Press Me!
        </button>
@endsection

@section('scripts')
    <!-- Import the compiled Vue component -->
    <script src="{{ mix('js/app.js') }}"></script>
@endsection


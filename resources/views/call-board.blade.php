@extends('layouts.evaluation')

@section('content')
    <div class="page-breadcrumb bg-white">
        <!-- Your content goes here -->
    </div>
    <div id="app">
        <call-board :cubicles="{{ json_encode($cubicles) }}" :evaluators="{{ json_encode($evaluators) }}" :examid="{{ json_encode($exam->id) }}" :manager="{{ json_encode($manager) }}"></call-board>
    </div>
@endsection

@section('scripts')
    <!-- Import the compiled Vue component -->
    <script src="{{ mix('js/app.js') }}"></script>
@endsection

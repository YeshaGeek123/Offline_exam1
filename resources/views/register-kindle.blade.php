@extends('layouts.guest')

@section('content')    
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-lg-4 col-md-6 col-sm-10">
                <div class="card" style="border: 1px solid #eee; margin-top: 22vh; background-color: ghostwhite;">
                    <div class="card-heading" style="background-color: ghostwhite;">
                        <h3 class="box-title mb-0">Register Kindle</h3>
                    </div>
                    <div class="card-body">
                        
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                
                        <form id="registerKindleForm" class="form-horizontal form-material" method="POST" action="{{ route('register-kindle') }}">
                            @csrf
                            
                            <input type="hidden" name="uuid" value="{{ $uuid }}">
                            <div class="form-group mb-4">
                                <label for="example-email" class="col-md-12 p-0">Operatory Number</label>
                                <div class="col-md-12 border-bottom p-0">
                                    <input type="number" placeholder="Enter operatory number" class="form-control p-0 border-0" id="cubicle_number" name="cubicle_number" required>
                                </div>
                            </div>
                            <div class="flex">
                                <button type="submit" class="btn btn-success">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#registerKindleForm').on('submit', function(e) {
            e.preventDefault();

            var cn = $('#cubicle_number').val();

            $.ajax({
                url: '/register-kindle-check/' + cn,
                type: 'get',
                dataType: 'json',
                success: function(res) {
                    if ( res.exists ) {
                        if (confirm("There is already a kindle registerd in this operatory. Are you sure you want to reset?") == true) {
                            $('#registerKindleForm').unbind('submit').submit();
                        }

                        return false;
                    }
                    else {
                        localStorage.setItem("srta-kindle-identifier", '{{ $uuid }}');

                        $('#registerKindleForm').unbind('submit').submit();
                    }
                }
            });
        });
    </script>
@endpush
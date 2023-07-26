<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name') }}</title>

    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('theme/plugins/images/favicon.png') }}">
    <link href="{{ asset('theme/plugins/bower_components/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('theme/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css') }}">
    <link href="{{ asset('theme/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js" integrity="sha512-mULnawDVcCnsk9a4aG1QLZZ6rcce/jSzEGqUkeOLy0b6q0+T6syHrxlsAGH7ZVoqC93Pd0lBqd6WguPWih7VHA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">
                    <a class="navbar-brand" href="dashboard.html">
                        <b class="logo-icon w-100">
                            <img class="w-100" src="{{ asset('theme/plugins/images/srta-logo.jpg') }}" alt="homepage" />
                        </b>
                    </a>
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
                        href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                   
                    <div class="navbar-nav ms-auto d-flex align-items-center">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $student->name }} <i class="fas fa-caret-down"></i>
                              </a>
                              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDarkDropdownMenuLink">
                
                                <li>
                                    <a class="dropdown-item" href="{{route('student-login-form')}}">
                                        <i class="fas fa-sign-out-alt"></i> Log Out
                                    </a>
                                </li>
                              </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        
        @include('layouts.partials.error-message')

        <aside class="left-sidebar" data-sidebarbg="skin6">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item pt-2 @hasSection('nav-dashboard') selected @yield('nav-dashboard') @endif">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-dashboard') active @yield('nav-dashboard') @endif" href="{{ route('dashboard') }}"
                                aria-expanded="false">
                                <i class="fas fa-home" aria-hidden="true"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="page-wrapper">
            
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4>
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
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-sm-6">
                        <form action="{{ route('student-finish') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ request('token') }}">
                            <input type="hidden" name="exam_id" value="{{ $student->exam_id }}">
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            @if (request('submitted') == 'true')
                                <button class="btn btn-lg btn-success w-100 disabled">NOTIFIED!</button>
                            @else
                                <button class="btn btn-lg btn-success w-100">FINISH EXAM</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <footer class="footer text-center"> {{ date('Y') }} © SRTA</footer>
        </div>
        
    </div>

    <div id="modal-skel" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto" id="title-skel">Broadcast Message</h2>
                </div>
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3" id="body-skel">
                    <div class="col-span-12"></div>
                </div>
                <div class="modal-footer text-right">
                    <form id="form-skel" action="" method="GET">
                            
                    <form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('theme/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('theme/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('theme/js/waves.js') }}"></script>
    {{-- <script src="{{ asset('theme/js/sidebarmenu.js') }}"></script> --}}
    <script src="{{ asset('theme/js/custom.js') }}"></script>>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script>
        var makeModal = function(l, m, h, method, input = null) {

            $('#title-skel').html(h);
            $('#body-skel div').html(m);
            $('#form-skel').attr('action', l);
            
            var form = '';
            
            if(method!='GET') {
                form+='@csrf';
                $('#form-skel').attr('method','POST');
            }
            else{
                $('#form-skel').attr('method','GET');
            }

            if(method=='PATCH') {
                form+='@method("PATCH")';
            }   
            else if(method=='DELETE') {
                form+='@method("DELETE")';
            }

            form+=`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Proceed</button>`;

            if(input) {
                input.forEach(function($k,$i) {
                    form+=$i;
                });
            }

            $('#form-skel').html(form);

            $("#modal-skel").modal('show');
        };
    </script>

    @stack('scripts')
</body>

</html>
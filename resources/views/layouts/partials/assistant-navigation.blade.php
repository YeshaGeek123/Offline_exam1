<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item pt-2 @hasSection('nav-dashboard') selected @yield('nav-dashboard') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-dashboard') active @yield('nav-dashboard') @endif" href="{{ route('assistant-dashboard') }}"
                        aria-expanded="false">
                        <i class="fas fa-home" aria-hidden="true"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item pt-2 @hasSection('nav-waiting') selected @yield('nav-waiting') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-waiting') active @yield('nav-waiting') @endif" href="{{ route('assistant-waiting-room') }}"
                        aria-expanded="false">
                        <i class="fa fa-stopwatch" aria-hidden="true"></i>
                        <span class="hide-menu">Waiting Room</span>
                    </a>
                </li>
                <li class="sidebar-item pt-2 @hasSection('nav-termination') selected @yield('nav-termination') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-termination') active @yield('nav-termination') @endif" href="{{ route('assistant-termination') }}"
                        aria-expanded="false">
                        <i class="fa fa-times" aria-hidden="true"></i>
                        <span class="hide-menu">Termination</span>
                    </a>
                </li>
                <li class="sidebar-item custom-mobile-item @hasSection('nav-exams') selected @yield('nav-exams') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-exams') active @yield('nav-exams') @endif" href="{{route('change-password')}}"
                        aria-expanded="false">
                        <i class="fas fa-lock-open" aria-hidden="true"></i>
                        <span class="hide-menu">Change Password</span>
                    </a>
                </li>
                <li class="sidebar-item custom-mobile-item @hasSection('nav-exams') selected @yield('nav-exams') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-exams') active @yield('nav-exams') @endif" href="#" onclick="event.preventDefault(); document.getElementById('ex-lg-frm').submit();"
                        aria-expanded="false">
                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                        <span class="hide-menu">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
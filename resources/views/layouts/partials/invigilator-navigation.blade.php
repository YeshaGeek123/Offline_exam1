<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item pt-2 @hasSection('nav-dashboard') selected @yield('nav-dashboard') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-dashboard') active @yield('nav-dashboard') @endif" href="{{ route('invigilator-dashboard') }}"
                        aria-expanded="false">
                        <i class="fas fa-home" aria-hidden="true"></i>
                        <span class="hide-menu">Dashboard</span>
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
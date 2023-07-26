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
                <li class="sidebar-item @hasSection('nav-users') selected @yield('nav-users') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-users') active @yield('nav-users') @endif" href="{{ route('users.index') }}"
                        aria-expanded="false">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        <span class="hide-menu">Users</span>
                    </a>
                </li>
                <li class="sidebar-item @hasSection('nav-sections') selected @yield('nav-sections') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-sections') active @yield('nav-sections') @endif" href="{{ route('sections.index') }}"
                        aria-expanded="false">
                        <i class="fas fa-list" aria-hidden="true"></i>
                        <span class="hide-menu">Sections</span>
                    </a>
                </li>
                <li class="sidebar-item @hasSection('nav-procedures') selected @yield('nav-procedures') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-procedures') active @yield('nav-procedures') @endif" href="{{ route('procedures.index') }}"
                        aria-expanded="false">
                        <i class="fa fa-procedures" aria-hidden="true"></i>
                        <span class="hide-menu">Procedures</span>
                    </a>
                </li>
                <li class="sidebar-item @hasSection('nav-categories') selected @yield('nav-categories') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-categories') active @yield('nav-categories') @endif" href="{{ route('categories.index') }}"
                        aria-expanded="false">
                        <i class="fas fa-code-branch" aria-hidden="true"></i>
                        <span class="hide-menu">Categories</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item @hasSection('nav-cubicles') selected @yield('nav-cubicles') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-cubicles') active @yield('nav-cubicles') @endif" href="{{ route('cubicles.index') }}"
                        aria-expanded="false">
                        <i class="fas fa-th-large" aria-hidden="true"></i>
                        <span class="hide-menu">Cubicles</span>
                    </a>
                </li> --}}
                <li class="sidebar-item @hasSection('nav-exams') selected @yield('nav-exams') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-exams') active @yield('nav-exams') @endif" href="{{ route('exams.index') }}"
                        aria-expanded="false">
                        <i class="fa fa-stopwatch" aria-hidden="true"></i>
                        <span class="hide-menu">Exams</span>
                    </a>
                </li>
                <li class="sidebar-item @hasSection('nav-questionnaires') selected @yield('nav-questionnaires') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-questionnaires') active @yield('nav-questionnaires') @endif" href="{{ route('questionnaires.index') }}"
                        aria-expanded="false">
                        <i class="fas fa-question" aria-hidden="true"></i>
                        <span class="hide-menu">Questionnaires</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item @hasSection('nav-results') selected @yield('nav-results') @endif">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @hasSection('nav-results') active @yield('nav-results') @endif" href="{{ route('results.index') }}"
                        aria-expanded="false">
                        <i class=" fas fa-clipboard-list" aria-hidden="true"></i>
                        <span class="hide-menu">Results</span>
                    </a>
                </li> --}}
                <li class="sidebar-item custom-mobile-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('change-password')}}"
                        aria-expanded="false">
                        <i class="fas fa-lock-open" aria-hidden="true"></i>
                        <span class="hide-menu">Change Password</span>
                    </a>
                </li>
                <li class="sidebar-item custom-mobile-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="#" onclick="event.preventDefault(); document.getElementById('ex-lg-frm').submit();"
                        aria-expanded="false">
                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                        <span class="hide-menu">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
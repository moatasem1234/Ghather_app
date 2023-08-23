<aside class="main-sidebar elevation-2 sidebar-primary bg-white">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link navbar-primary">
        <img src="{{ asset('images/logos/icon.png') }}" alt="GATHER" class="brand-image">
        <span class="brand-text font-weight-ligh text-white">GATHER</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- SidebarSearch Form -->
        <div class="form-inline mt-2">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2 pb-5">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link @if ($menu == 'Dashboard') active @endif">
                        <i class="nav-icon fas fa-chart-area"></i>
                        <p> Dashboard </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.notify.index')}}"
                       class="nav-link @if ($menu == 'notify') active @endif">
                        <i class="nav-icon fa fa-paper-plane" aria-hidden="true"></i>
                        <p> Send Notification </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('courses.index') }}"
                        class="nav-link @if ($menu == 'Courses') active @endif">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p> Courses </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cu.index') }}"
                       class="nav-link @if ($menu == 'Student_Courses') active @endif">
                        <i class="nav-icon fa fa-user-circle"></i>
                        <p> Student_Courses </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('lesson.index') }}"
                       class="nav-link @if ($menu == 'Lessons') active @endif">
                        <i class="nav-icon fa fa-bookmark"></i>
                        <p> Lessons </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.assignments.store') }}"
                       class="nav-link @if ($menu == 'Assignments') active @endif">
                        <i class="nav-icon fa fa-building"></i>
                        <p> Assignments </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.answers.index') }}"
                       class="nav-link @if ($menu == 'Answers') active @endif">
                        <i class="nav-icon fa fa-envelope-open"></i>
                        <p> Answer Assignments </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('tests.index') }}"
                       class="nav-link @if ($menu == 'Tests') active @endif">
                        <i class="nav-icon fa fa-check-square"></i>
                        <p> Exams </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('questions.index') }}"
                       class="nav-link @if ($menu == 'Questions') active @endif">
                        <i class="nav-icon fa fa-question"></i>
                        <p> Questions </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('question_options.index') }}"
                       class="nav-link @if ($menu == 'Questions_Options') active @endif">
                        <i class="nav-icon fa fa-list-alt "></i>
                        <p> Questions options </p>
                    </a>
                </li>

               

                <li class="nav-item">
                    <a target="_blank" href="https://meet.gather-sy.com/"
                       class="nav-link @if ($menu == 'Recording') active @endif">
                        <i class="nav-icon fa fa-video" aria-hidden="true"></i>
                        <p> Meeting </p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

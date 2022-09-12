<ul class="nav">
    <li class="nav-item nav-category">Main</li>
    <li class="nav-item  @if (Request::is('*/dashboard')) active @endif">
        <a href="/" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
        </a>
    </li>
    <li class="nav-item nav-category">Human Resource</li>
    <li class="nav-item @if (Request::is('admin/employees*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false"
            aria-controls="emails">
            <i class="link-icon" data-feather="anchor"></i>
            <span class="link-title">Employees</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/employees*')) show @endif" id="emails">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.employees.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employees.index') active @endif">List of
                        Employees</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employees.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employees.create') active @endif">Create a new
                        employee</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/attendance*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#attendance" role="button" aria-expanded="false"
            aria-controls="attendance">
            <i class="link-icon" data-feather="calendar"></i>
            <span class="link-title">Attendance</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/attendance*')) show @endif" id="attendance">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.attendance.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.attendance.index') active @endif">Attendance Register</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.attendance.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.attendance.create') active @endif">Add Attendance Records</a>
                </li>
            </ul>
        </div>
    </li>

</ul>

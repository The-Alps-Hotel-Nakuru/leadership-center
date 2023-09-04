<ul class="nav">
    <li class="nav-item nav-category">Main</li>
    <li class="nav-item  @if (Request::is('*/dashboard')) active @endif">
        <a href="/" class="nav-link">
            <i class="material-icons material-symbols-outlined">
                dashboard
            </i>
            <span class="link-title">Dashboard</span>
        </a>
    </li>
    <li class="nav-item nav-category">Accounting</li>
    <li class="nav-item  @if (Request::is('*/dashboard')) active @endif">
        <a href="/" class="nav-link">
            <i class="material-icons material-symbols-outlined">
                monitoring
            </i>
            <span class="link-title">Analytics</span>
        </a>
    </li>
    <li class="nav-item @if (Request::is('admin/banks*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#banks" role="button" aria-expanded="false"
            aria-controls="banks">
            <i class="material-icons material-symbols-outlined">
                account_balance
            </i>
            <span class="link-title">Banks</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/admins*')) show @endif" id="banks">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.banks.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.banks.index') active @endif">List of
                        Banks</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.banks.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.banks.create') active @endif">Create a new
                        Bank</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.banks.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.banks.mass_addition') active @endif">Banks Mass Addition</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item nav-category">Human Resource</li>
    <li class="nav-item @if (Request::is('admin/admins*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#admins" role="button" aria-expanded="false"
            aria-controls="admins">
            <i class="material-icons material-symbols-outlined">
                admin_panel_settings
            </i>
            <span class="link-title">Administrators</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/admins*')) show @endif" id="admins">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.admins.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.admins.index') active @endif">List of
                        Administrators</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.admins.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.admins.create') active @endif">Create a new
                        Administrator</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/departments*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#departments" role="button" aria-expanded="false"
            aria-controls="departments">
            <i class="material-icons material-symbols-outlined">
                workspaces
            </i>
            <span class="link-title">Departments</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/departments*')) show @endif" id="departments">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.departments.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.departments.index') active @endif">
                        Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.departments.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.departments.create') active @endif">
                        Create a new Department</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/designations*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#designations" role="button" aria-expanded="false"
            aria-controls="designations">
            <i class="material-icons material-symbols-outlined">
                work
            </i>
            <span class="link-title">Designations</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/designations*')) show @endif" id="designations">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.designations.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.designations.index') active @endif">
                        Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.designations.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.designations.create') active @endif">
                        Create a new Designation</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item  @if (Request::is('admin/responsibilities*')) active @endif">
        <a href="{{ route('admin.responsibilities.index') }}" class="nav-link">
            <i class="material-icons material-symbols-outlined">
                account_tree
            </i>
            <span class="link-title">Responsibilities</span>
        </a>
    </li>
    <li class="nav-item @if (Request::is('admin/employees*') || Request::is('admin/employee_contracts*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false"
            aria-controls="emails">
            <i class="material-icons material-symbols-outlined">
                badge
            </i>
            <span class="link-title">Employees</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/employees*') || Request::is('admin/employee_contracts*')) show @endif" id="emails">
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
                <li class="nav-item">
                    <a href="{{ route('admin.employee_contracts.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_contracts.index') active @endif">View Employee Contracts</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employee_contracts.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_contracts.create') active @endif">Create an Employee
                        Contract</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employees.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employees.mass_addition') active @endif">Mass Employee Creation</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employee_contracts.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_contracts.mass_addition') active @endif">Mass Contracts Addition</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/employee_accounts*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#employee_accounts" role="button"
            aria-expanded="false" aria-controls="emails">
            <i class="material-icons material-symbols-outlined">
                account_balance_wallet
            </i>
            <span class="link-title">Employees' Accounts</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/employee_accounts*')) show @endif" id="employee_accounts">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.employee_accounts.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_accounts.index') active @endif">Accounts List</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employee_accounts.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_accounts.create') active @endif">Add an Account</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employee_accounts.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_accounts.mass_addition') active @endif">Mass Addition</a>
                </li>
            </ul>
        </div>

    </li>
    <li class="nav-item @if (Request::is('admin/attendances*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#attendances" role="button" aria-expanded="false"
            aria-controls="attendances">
            <i class="material-icons material-symbols-outlined">
                event_available
            </i>
            <span class="link-title">Attendances</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/attendances*')) show @endif" id="attendances">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.attendances.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.attendances.index') active @endif">Attendance Register</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.attendances.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.attendances.create') active @endif">Add Attendance Records</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.attendances.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.attendances.mass_addition') active @endif">Attendance Mass Addition</a>
                </li>

            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/leaves*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#leaves" role="button" aria-expanded="false"
            aria-controls="leaves">
            <i class="material-icons material-symbols-outlined">
                free_cancellation
            </i>
            <span class="link-title">leaves</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/leaves*')) show @endif" id="leaves">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.leaves.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.leaves.index') active @endif">Leave Days List</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.leaves.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.leaves.create') active @endif">Add Leave Records</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.leaves.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.leaves.mass_addition') active @endif">Leave Mass Addition</a>
                </li>

            </ul>
        </div>
    </li>

    <li class="nav-item @if (Request::is('admin/fines*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#fines" role="button" aria-expanded="false"
            aria-controls="fines">
            <i class="material-icons material-symbols-outlined">
                money_off
            </i>
            <span class="link-title">Fines</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/fines*')) show @endif" id="fines">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.fines.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.fines.index') active @endif">Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.fines.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.fines.create') active @endif">Add Fine Records</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.employee_fines.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_fines.mass_addition') active @endif">Mass Fines Addition</a>
                </li>

            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/bonuses*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#bonuses" role="button" aria-expanded="false"
            aria-controls="bonuses">
            <i class="material-icons material-symbols-outlined">
                paid
            </i>
            <span class="link-title">Bonuses</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/bonuses*')) show @endif" id="bonuses">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.bonuses.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.bonuses.index') active @endif">Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.bonuses.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.bonuses.create') active @endif">Add Bonus Records</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.employee_bonuses.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_bonuses.mass_addition') active @endif">Mass Bonuses Addition</a>
                </li>

            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/welfare_contributions*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#welfare_contributions" role="button"
            aria-expanded="false" aria-controls="welfare_contributions">
            <i class="material-icons material-symbols-outlined">
                card_membership
            </i>
            <span class="link-title">Staff Welfare</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/welfare_contributions*')) show @endif" id="welfare_contributions">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.welfare_contributions.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.welfare_contributions.index') active @endif">Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.welfare_contributions.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.welfare_contributions.create') active @endif">Add Contribution</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.welfare_contributions.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.welfare_contributions.mass_addition') active @endif">Mass Contribution</a>
                </li>

            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/advances*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#advances" role="button" aria-expanded="false"
            aria-controls="advances">
            <i class="material-icons material-symbols-outlined">
                decimal_decrease
            </i>
            <span class="link-title">Advances</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/advances*')) show @endif" id="advances">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.advances.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.advances.index') active @endif">Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.advances.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.advances.create') active @endif">Add Advances Records</a>
                </li>

            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/payrolls*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#payrolls" role="button" aria-expanded="false"
            aria-controls="payrolls">
            <i class="material-icons material-symbols-outlined">
                paid
            </i>
            <span class="link-title">Payroll</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/payrolls*')) show @endif" id="payrolls">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.payrolls.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.payrolls.index') active @endif">Overview</a>
                </li>
            </ul>
        </div>
    </li>

</ul>

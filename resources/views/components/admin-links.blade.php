<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

    <li class="nav-header text-underline">Initialization</li>

    {{-- Dashboard --}}
    <x-new-nav-link fa_icon="fa-xs fa-check" title="Dashboard" route="admin.dashboard" fa_icon="fa-tachometer-alt"></x-new-nav-link>
    {{-- <x-new-nav-link fa_icon="fa-xs fa-check" title="Analytics" route="admin.analytics" fa_icon="fa-chart-bar"></x-new-nav-link> --}}
    <x-new-nav-link-dropdown title="Settings" route="admin.settings*" fa_icon="fa-cogs">
        <x-new-nav-link fa_icon="fa-xs fa-check" title="General" route="admin.settings.general"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Mail" route="admin.settings.mail"></x-new-nav-link>

    </x-new-nav-link-dropdown>
    <x-new-nav-link-dropdown title="Banks" route="admin.banks*" fa_icon="fa-university">
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Overview" route="admin.banks.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create a Bank" route="admin.banks.create"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create Multiple Banks" route="admin.banks.mass_addition"></x-new-nav-link>


    </x-new-nav-link-dropdown>

    <li class="nav-header">Human Resource</li>
    <x-new-nav-link-dropdown title="Admins" route="admin.admins*" fa_icon="fa-user-cog">
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Overview" route="admin.admins.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create a Bank" route="admin.admins.create"></x-new-nav-link>
    </x-new-nav-link-dropdown>
    <x-new-nav-link-dropdown title="Departments" route="admin.departments*" fa_icon="fa-building">
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Overview" route="admin.departments.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create a Department" route="admin.departments.create"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Designations List" route="admin.designations.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create a Designation" route="admin.designations.create"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="List of Responsibilities" route="admin.responsibilities.index"></x-new-nav-link>
    </x-new-nav-link-dropdown>
    <x-new-nav-link-dropdown title="Employees" route="admin.employees*" fa_icon="fa-user-md">
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Overview" route="admin.employees.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create a Bank" route="admin.employees.create"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create Multiple Employees" route="admin.employees.mass_addition"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="List of Contracts" route="admin.employee_contracts.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create a Contract" route="admin.employee_contracts.create"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create Multiple Employee_contracts"
            route="admin.employee_contracts.mass_addition"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Bank Accounts" route="admin.employee_accounts.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create Multiple Employee Accounts"
            route="admin.employee_accounts.mass_addition"></x-new-nav-link>


    </x-new-nav-link-dropdown>
    <x-new-nav-link-dropdown title="Attendances" route="admin.attendances*" fa_icon="fa-calendar-check">
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Overview" route="admin.attendances.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create a Bank" route="admin.attendances.create"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create Multiple Attendances" route="admin.attendances.mass_addition"></x-new-nav-link>


    </x-new-nav-link-dropdown>
    <x-new-nav-link-dropdown title="Leaves" route="admin.leaves*" fa_icon="fa-umbrella-beach">
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Overview" route="admin.leaves.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create a Bank" route="admin.leaves.create"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create Multiple Leaves" route="admin.leaves.mass_addition"></x-new-nav-link>


    </x-new-nav-link-dropdown>
    @php
        $routeOne = ['admin.fines*', 'admin.bonuses*', 'admin.advances*', 'admin.welfare_contributions*'];

    @endphp
    <x-new-nav-link-dropdown title="Salary Adjustments" active="{{ request()->routeIs($routeOne) ? true : false }}"
        route="" fa_icon="fa-money-bill ">
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Fines" route="admin.fines.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Bonuses" route="admin.bonuses.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Salary Advances" route="admin.advances.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Welfare Contributions" route="admin.welfare_contributions.index"></x-new-nav-link>


    </x-new-nav-link-dropdown>
    <x-new-nav-link-dropdown title="Payroll" route="admin.payrolls*" fa_icon="fa-cash-register">
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Overview" route="admin.payrolls.index"></x-new-nav-link>
    </x-new-nav-link-dropdown>
</ul>

{{--
<ul class="nav">

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
                        class="nav-link @if (Route::currentRouteName() == 'admin.employees.index') active @endif">
                        List of Employees
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employees.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employees.create') active @endif">
                        Create a new employee
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employee_contracts.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_contracts.index') active @endif">
                        View Employee Contracts
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employee_contracts.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_contracts.create') active @endif">
                        Create an Employee Contract
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employees.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employees.mass_addition') active @endif">
                        Mass Employee Creation
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employee_contracts.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_contracts.mass_addition') active @endif">
                        Mass Contracts Addition
                    </a>
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
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_accounts.index') active @endif">
                        Accounts List
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employee_accounts.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_accounts.create') active @endif">
                        Add an Account
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employee_accounts.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_accounts.mass_addition') active @endif">
                        Mass Addition
                    </a>
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
                        class="nav-link @if (Route::currentRouteName() == 'admin.attendances.index') active @endif">
                        Attendance Register
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.attendances.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.attendances.create') active @endif">
                        Add Attendance Records
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.attendances.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.attendances.mass_addition') active @endif">
                        Attendance Mass Addition
                    </a>
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
                        class="nav-link @if (Route::currentRouteName() == 'admin.leaves.index') active @endif">
                        Leave Days List
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.leaves.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.leaves.create') active @endif">
                        Add Leave Records
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.leaves.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.leaves.mass_addition') active @endif">
                        Leave Mass Addition
                    </a>
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
                        class="nav-link @if (Route::currentRouteName() == 'admin.fines.index') active @endif">
                        Overview
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.fines.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.fines.create') active @endif">
                        Add Fine Records
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.employee_fines.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_fines.mass_addition') active @endif">
                        Mass Fines Addition
                    </a>
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
                        class="nav-link @if (Route::currentRouteName() == 'admin.bonuses.index') active @endif">
                        Overview
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.bonuses.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.bonuses.create') active @endif">
                        Add Bonus Records
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.employee_bonuses.mass_addition') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_bonuses.mass_addition') active @endif">
                        Mass Bonuses Addition
                    </a>
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

</ul> --}}

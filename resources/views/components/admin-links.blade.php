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
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create an Admin" route="admin.admins.create"></x-new-nav-link>
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
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create an Employee" route="admin.employees.create"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create Multiple Employees" route="admin.employees.mass_addition"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="List of Contracts" route="admin.employee_contracts.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create a Contract" route="admin.employee_contracts.create"></x-new-nav-link>
        <x-new-nav-link fa_icon="fa-xs fa-check" title="Create Multiple Employee Contracts"
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

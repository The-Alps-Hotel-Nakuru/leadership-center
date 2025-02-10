<li class="nav-header text-underline">Initialization</li>

{{-- Dashboard --}}
<x-new-nav-link bi_icon="" title="Dashboard" route="admin.dashboard" bi_icon="bi-speedometer"></x-new-nav-link>
{{-- <x-new-nav-link bi_icon="" title="Analytics" route="admin.analytics" bi_icon="bi-chart-bar"></x-new-nav-link> --}}
<x-new-nav-link-dropdown title="Settings" route="admin.settings*" bi_icon="bi-gear">
    <x-new-nav-link bi_icon="" title="General" route="admin.settings.general"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Mail" route="admin.settings.mail"></x-new-nav-link>

</x-new-nav-link-dropdown>
<x-new-nav-link-dropdown title="Banks" route="admin.banks*" bi_icon="bi-bank">
    <x-new-nav-link bi_icon="" title="Overview" route="admin.banks.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create a Bank" route="admin.banks.create"></x-new-nav-link>
    {{-- <x-new-nav-link bi_icon="" title="Create Multiple Banks" route="admin.banks.mass_addition"></x-new-nav-link> --}}


</x-new-nav-link-dropdown>
<x-new-nav-link-dropdown title="Employment Types" route="admin.employment-types*" bi_icon="bi-briefcase">
    <x-new-nav-link bi_icon="" title="Overview" route="admin.employment-types.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create an Employment Type"
        route="admin.employment-types.create"></x-new-nav-link>
    {{-- <x-new-nav-link bi_icon="" title="Create Multiple Banks" route="admin.banks.mass_addition"></x-new-nav-link> --}}


</x-new-nav-link-dropdown>

<li class="nav-header">Human Resource</li>
<x-new-nav-link-dropdown title="Admins" route="admin.admins*" bi_icon="bi-person-gear">
    <x-new-nav-link bi_icon="" title="Overview" route="admin.admins.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create an Admin" route="admin.admins.create"></x-new-nav-link>
</x-new-nav-link-dropdown>
<x-new-nav-link-dropdown title="Security Guards" route="admin.security_guards*" bi_icon="bi-person-lock">
    <x-new-nav-link bi_icon="" title="Overview" route="admin.security_guards.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create a Security Guard"
        route="admin.security_guards.create"></x-new-nav-link>
</x-new-nav-link-dropdown>
@php
    $routeOne = ['admin.departments*', 'admin.designations*', 'admin.responsibilities*'];

@endphp
<x-new-nav-link-dropdown active="{{ request()->routeIs($routeOne) ? true : false }}" route="" title="Departments"
    route="admin.departments*" bi_icon="bi-building">
    <x-new-nav-link bi_icon="" title="Overview" route="admin.departments.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create a Department" route="admin.departments.create"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Designations List" route="admin.designations.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create a Designation" route="admin.designations.create"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="List of Responsibilities" route="admin.responsibilities.index"
        active="{{ request()->routeIs('admin.responsibilities.create') ? true : false }}"></x-new-nav-link>
</x-new-nav-link-dropdown>

@php
    $routeTwo = ['admin.employees*', 'admin.employee_contracts*', 'admin.employee_accounts*', 'admin.bans*'];

@endphp
<x-new-nav-link-dropdown title="Employees" active="{{ request()->routeIs($routeTwo) ? true : false }}" route=""
    bi_icon="bi-person-badge">
    <x-new-nav-link bi_icon="" title="Overview" route="admin.employees.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create an Employee" route="admin.employees.create"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create Multiple Employees"
        route="admin.employees.mass_addition"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Banned Employees" route="admin.bans.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="List of Contracts" route="admin.employee_contracts.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create a Contract" route="admin.employee_contracts.create"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create Multiple Employee Contracts"
        route="admin.employee_contracts.mass_addition"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Bank Accounts" route="admin.employee_accounts.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create Multiple Employee Accounts"
        route="admin.employee_accounts.mass_addition"></x-new-nav-link>
</x-new-nav-link-dropdown>


<li class="nav-header">Datings</li>
{{-- <x-new-nav-link-dropdown title="Biometrics Users" route="admin.biometrics*" bi_icon="bi-fingerprint">
    <x-new-nav-link bi_icon="" title="Overview" route="admin.biometrics.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Add Employee Record" route="admin.biometrics.create"></x-new-nav-link>
</x-new-nav-link-dropdown> --}}
<x-new-nav-link-dropdown title="Attendances" route="admin.attendances*" bi_icon="bi-calendar-check">
    <x-new-nav-link bi_icon="" title="Overview" route="admin.attendances.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Add an Attendance Record"
        route="admin.attendances.create"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create Multiple Attendances"
        route="admin.attendances.mass_addition"></x-new-nav-link>
</x-new-nav-link-dropdown>
<x-new-nav-link-dropdown title="Extra Hours" route="admin.extra-works*" bi_icon="bi-calendar-check">
    <x-new-nav-link bi_icon="" title="Overview" route="admin.extra-works.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Add an Overtime Record" route="admin.extra-works.create"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create Multiple Overtime Records"
        route="admin.extra-works.mass_addition"></x-new-nav-link>
</x-new-nav-link-dropdown>
<x-new-nav-link-dropdown title="Leave Types" route="admin.leave-types*" bi_icon="bi-calendar">
    <x-new-nav-link bi_icon="" title="Overview" route="admin.leave-types.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create Leave Type" route="admin.leave-types.create"></x-new-nav-link>
</x-new-nav-link-dropdown>
<x-new-nav-link-dropdown title="Leaves" route="admin.leaves*" bi_icon="bi-calendar-week">
    <x-new-nav-link bi_icon="" title="Overview" route="admin.leaves.index"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Add a Leave Record" route="admin.leaves.create"></x-new-nav-link>
    <x-new-nav-link bi_icon="" title="Create Multiple Leaves"
        route="admin.leaves.mass_addition"></x-new-nav-link>
</x-new-nav-link-dropdown>
<x-new-nav-link title="Leave Requests" route="admin.leave-requests.index"
    bi_icon="bi-calendar-x"></x-new-nav-link-dropdown>
    <x-new-nav-link-dropdown title="Holidays" route="admin.holidays*" bi_icon="bi-snow3">
        <x-new-nav-link bi_icon="" title="Overview" route="admin.holidays.index"></x-new-nav-link>
        <x-new-nav-link bi_icon="" title="Add a Holiday" route="admin.holidays.create"></x-new-nav-link>
    </x-new-nav-link-dropdown>



    <li class="nav-header">Accounting</li>
    @php
        $routeThree = ['admin.fines*', 'admin.bonuses*', 'admin.advances*', 'admin.welfare_contributions*'];

    @endphp
    <x-new-nav-link-dropdown title="Salary Adjustments" active="{{ request()->routeIs($routeThree) ? true : false }}"
        route="" bi_icon="bi-piggy-bank ">
        <x-new-nav-link bi_icon="" title="Fines" route="admin.fines.index"></x-new-nav-link>
        <x-new-nav-link bi_icon="" title="Bonuses" route="admin.bonuses.index"></x-new-nav-link>
        <x-new-nav-link bi_icon="" title="Salary Advances" route="admin.advances.index"></x-new-nav-link>
        <x-new-nav-link bi_icon="" title="Welfare Contributions"
            route="admin.welfare_contributions.index"></x-new-nav-link>


    </x-new-nav-link-dropdown>
    <x-new-nav-link-dropdown title="Loan Management" route="admin.loans*" bi_icon="bi-currency-exchange">
        <x-new-nav-link bi_icon="" title="List of Loans" route="admin.loans.index"></x-new-nav-link>
        <x-new-nav-link bi_icon="" title="Create a new Loan " route="admin.loans.create"></x-new-nav-link>

    </x-new-nav-link-dropdown>
    <x-new-nav-link-dropdown title="Payroll" route="admin.payrolls*" bi_icon="bi-cash-coin">
        <x-new-nav-link bi_icon="" title="Overview" route="admin.payrolls.index"></x-new-nav-link>
        <x-new-nav-link bi_icon="" title="Payments" route="admin.payroll_payments.index"></x-new-nav-link>
    </x-new-nav-link-dropdown>


<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    {{-- Dashboard --}}
    <li class="nav-header">Initialization</li>
    <x-new-nav-link title="Dashboard" route="employee.dashboard" fa_icon="fa-tachometer-alt"></x-new-nav-link>

    <li class="nav-header">Employment Details</li>
    <x-new-nav-link title="My Profile" route="employee.profile" fa_icon="fa-user-cog"></x-new-nav-link>
    <x-new-nav-link title="My Contracts" route="employee.contracts" fa_icon="fa-cash-register"></x-new-nav-link>

    <li class="nav-header">Accounts</li>
    <x-new-nav-link title="Payslips" route="employee.payslips" fa_icon="fa-money-check"></x-new-nav-link>

    <li class="nav-header">Support</li>
    <x-new-nav-link-dropdown title="My Leave Requests" route="employee.leave-requests*" fa_icon="fa-calendar-times">
        <x-new-nav-link fa_icon="" title="Overview" route="employee.leave-requests.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="" title="New Leave Request" route="employee.leave-requests.create"></x-new-nav-link>
    </x-new-nav-link-dropdown>
    {{-- <x-new-nav-link-dropdown title="Advance Management" route="employee.advance-requests*" fa_icon="fa-coins">
        <x-new-nav-link fa_icon="" title="Advance Overview" route="employee.advance-requests.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="" title="New Advance Request" route="employee.advance-requests.create"></x-new-nav-link>
    </x-new-nav-link-dropdown>
    <x-new-nav-link-dropdown title="Loan Management" route="employee.loan-requests*" fa_icon="fa-wallet">
        <x-new-nav-link fa_icon="" title="Loan Overview" route="employee.loan-requests.index"></x-new-nav-link>
        <x-new-nav-link fa_icon="" title="New Loan Request" route="employee.loan-requests.create"></x-new-nav-link>
    </x-new-nav-link-dropdown> --}}

</ul>

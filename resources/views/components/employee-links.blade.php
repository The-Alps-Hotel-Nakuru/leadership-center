<ul class="nav">
    <li class="nav-item nav-category">Main</li>
    <li class="nav-item  @if (Request::is('*/dashboard')) active @endif">
        <a href="{{ route('employee.dashboard') }}" class="nav-link">
            <i class="material-icons material-symbols-outlined">
                dashboard
            </i>
            <span class="link-title">Dashboard</span>
        </a>
    </li>
    <li class="nav-item nav-category">Accounts</li>
    <li class="nav-item  @if (Request::is('*/payslips')) active @endif">
        <a href="{{ route('employee.payslips') }}" class="nav-link">
            <i class="material-icons material-symbols-outlined">
                receipt_long
            </i>
            <span class="link-title">Payslips</span>
        </a>
    </li>
    <li class="nav-item  @if (Request::is('*/profile')) active @endif">
        <a href="{{ route('employee.profile') }}" class="nav-link">
            <i class="material-icons material-symbols-outlined">
                manage_accounts
            </i>
            <span class="link-title">My Profile</span>
        </a>
    </li>
</ul>

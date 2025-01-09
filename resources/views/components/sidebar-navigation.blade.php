<div class="sidebar-wrapper">
    <nav class="mt-2"> <!--begin::Sidebar Menu-->
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">


            @if (auth()->user()->is_admin)
                <x-admin-links></x-admin-links>
            @elseif (auth()->user()->is_employee)
                <x-employee-links></x-employee-links>
            @elseif (auth()->user()->is_security_guard)
                <x-security-links></x-security-links>
            @endif
            <br>
            <br>
            <br>
            <x-application-logo class="img-fluid w-50"/>
            <br>
        </ul>

    </nav>
</div>

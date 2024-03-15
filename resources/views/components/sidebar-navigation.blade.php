@if (auth()->user()->is_admin)
    <x-admin-links></x-admin-links>
@elseif (auth()->user()->is_employee)
    <x-employee-links></x-employee-links>
@endif
<br>
<br>
<br>
<x-jet-application-logo class="img-fluid w-50"/>
<br>

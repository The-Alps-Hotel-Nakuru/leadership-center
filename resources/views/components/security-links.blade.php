<li class="nav-header text-underline">Initialization</li>

{{-- Dashboard --}}
<x-new-nav-link fa_icon="" title="Dashboard" route="security.dashboard" fa_icon="fa-tachometer-alt"></x-new-nav-link>

<x-new-nav-link-dropdown title="Users" route="security.users*" fa_icon="fa-users-cog">
    <x-new-nav-link fa_icon="" title="Users Not Approved" route="security.users.index"></x-new-nav-link>
    <x-new-nav-link fa_icon="" title="Add Users" route="security.users.create"></x-new-nav-link>

</x-new-nav-link-dropdown>
<x-new-nav-link-dropdown title="Users" route="security.users*" fa_icon="fa-users-cog">
    <x-new-nav-link fa_icon="" title="Users Not Approved" route="security.users.index"></x-new-nav-link>
    <x-new-nav-link fa_icon="" title="Add Users" route="security.users.create"></x-new-nav-link>

</x-new-nav-link-dropdown>

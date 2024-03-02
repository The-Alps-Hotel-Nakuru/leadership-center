@props(['route' => null, 'title', 'fa_icon' => null, 'active' => false])

<li class="nav-item ">
    <a href="#"
        class="nav-link {{ request()->routeIs($route) || $active ? 'active menu-is-opening menu-open' : '' }}">
        @if ($fa_icon)
            <i class="nav-icon fas {{ $fa_icon }}"></i>
        @endif
        <p>
            {{ $title }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="{{ request()->routeIs($route) || $active ? 'display:block' : 'display:none' }}">
        {{ $slot }}
    </ul>
</li>

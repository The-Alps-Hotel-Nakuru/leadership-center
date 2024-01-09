@props(['title', 'route', 'new' => false, 'fa_icon' => null, 'active' => false])

<li class="nav-item">
    <a href="{{ route($route) }}" class="nav-link {{ request()->routeIs($route) || $active ? 'active' : '' }}">
        @if ($fa_icon)
            <i class="nav-icon fas {{ $fa_icon }}"></i>
        @endif
        <p>
            {{ $title }}
            @if ($new)
                <span class="right badge badge-danger">New</span>
            @endif
        </p>
    </a>
</li>

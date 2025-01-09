<nav class="app-header navbar navbar-expand">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i>
                </a>
            </li>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ auth()->user()->profile_photo_url }}" class="user-image rounded-circle shadow"
                        alt="User Image">
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="{{ auth()->user()->profile_photo_url }}" class="rounded-circle shadow"
                            alt="User Image">
                        <p>
                            {{ auth()->user()->name }}
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="{{ auth()->user()->is_employee?route('employee.profile'):route('profile.show') }}" class="btn btn-default btn-flat">Profile</a>
                        <a class="btn btn-default btn-flat float-end" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Sign out') }}
                        </a>
                        <form method="POST" id="logout-form" action="{{ route('logout') }}">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

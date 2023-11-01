<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">
    <!-- Scripts -->

    @vite('resources/sass/app.scss')
    {{-- @vite( 'resources/js/app.css') --}}
    <link rel="stylesheet" href="/assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="/assets/css/demo1/style.css">
    <link rel="shortcut icon" href="/assets/images/favicon.png" />
    {{-- <link rel="stylesheet" href="" /> --}}
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Styles -->
    @livewireStyles

    <style>

    </style>
</head>

<body>
    <div class="main-wrapper">
        <nav class="sidebar">
            <div class="sidebar-header">
                <a href="javascript:void(0)" class="sidebar-brand">
                    Alps<span>Control</span>
                </a>
                <div class="sidebar-toggler not-active">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="sidebar-body">
                @if (auth()->user()->is_admin)
                    <x-admin-links></x-admin-links>
                @elseif (auth()->user()->is_employee)
                    <x-employee-links></x-employee-links>
                @endif
                <x-jet-authentication-card-logo />
            </div>
        </nav>


        <div class="page-wrapper">
            <nav class="navbar">
                <a href="javascript:void(0)" class="sidebar-toggler">
                    <i data-feather="menu"></i>
                </a>
                <div class="navbar-content">
                    <form class="search-form">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i data-feather="search"></i>
                            </div>
                            <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
                        </div>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="profileDropdown"
                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="wd-30 ht-30 rounded-circle" src="{{ auth()->user()->profile_photo_url }}"
                                    alt="profile">
                            </a>
                            <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                                <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                                    <div class="mb-3">
                                        <img class="wd-80 ht-80 rounded-circle"
                                            src="{{ auth()->user()->profile_photo_url }}" alt="">
                                    </div>
                                    <div class="text-center">
                                        <p class="tx-16 fw-bolder">{{ auth()->user()->name }}</p>
                                        <p class="tx-12 text-muted">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                                <ul class="list-unstyled p-1">
                                    <li class="dropdown-item py-2">
                                        <a href="{{ Request::is('employee/*') ? route('employee.profile') : route('profile.show') }}"
                                            class="text-body ms-0">
                                            <i class="me-2 icon-md" data-feather="user"></i>
                                            <span>Profile</span>
                                        </a>
                                    </li>

                                    <li class="dropdown-item py-2">
                                        <a href="javascript:;" onclick="document.getElementById('logout-form').submit()"
                                            class="text-body ms-0">
                                            <i class="me-2 icon-md" data-feather="log-out"></i>
                                            <span>Log Out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="post">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- partial -->

            <div class="page-content">
                @if (isset($header))
                    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                        <div>
                            <h4 class="mb-3 mb-md-0">{{ $header }}</h4>
                        </div>
                    </div>
                @endif

                {{ $slot }}

            </div>

        </div>
    </div>
    @vite('resources/js/app.js')
    @stack('modals')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="/assets/vendors/feather-icons/feather.min.js"></script>
    <script src="/assets/js/template.js"></script>


    @livewireScripts
    @stack('scripts')
    <script>
        Livewire.on('done', (e) => {

            if (e.success) {
                Toast.fire({
                    icon: 'success',
                    text: e.success
                })
            }
            if (e.warning) {
                Toast.fire({
                    icon: 'warning',
                    text: e.warning
                })
            }
            if (e.danger) {
                Toast.fire({
                    icon: 'danger',
                    text: e.danger
                })
            }

            let instance = document.querySelector('.modal')
            let modal = bootstrap.Modal.getInstance(instance);
            modal.hide()
        })
        feather.replace()
    </script>


</body>

</html>

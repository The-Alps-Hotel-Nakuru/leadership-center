<ul class="nav">
    <li class="nav-item nav-category">Main</li>
    <li class="nav-item  @if (Request::is('*/dashboard')) active @endif">
        <a href="/" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
        </a>
    </li>
    <li class="nav-item nav-category">Human Resource</li>
    <li class="nav-item @if (Request::is('admin/admins*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#admins" role="button" aria-expanded="false"
            aria-controls="admins">
            <i class="link-icon" data-feather="anchor"></i>
            <span class="link-title">Administrators</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/admins*')) show @endif" id="admins">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.admins.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.admins.index') active @endif">List of
                        Administrators</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.admins.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.admins.create') active @endif">Create a new
                        Administrator</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/employees*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false"
            aria-controls="emails">
            <i class="link-icon" data-feather="anchor"></i>
            <span class="link-title">Employees</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/employees*')) show @endif" id="emails">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.employees.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employees.index') active @endif">List of
                        Employees</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employees.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employees.create') active @endif">Create a new
                        employee</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/attendances*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#attendances" role="button" aria-expanded="false"
            aria-controls="attendances">
            <i class="link-icon" data-feather="calendar"></i>
            <span class="link-title">Attendances</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/attendances*')) show @endif" id="attendances">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.attendances.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.attendances.index') active @endif">Attendance Register</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.attendances.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.attendances.create') active @endif">Add Attendance Records</a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item nav-category">Supply Chain & Procurement</li>
    <li class="nav-item @if (Request::is('admin/product_categories*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#product_categories" role="button" aria-expanded="false"
            aria-controls="product_categories">
            <i class="link-icon" data-feather="database"></i>
            <span class="link-title">Categories of Products</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/product_categories*')) show @endif" id="product_categories">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.product_categories.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.product_categories.index') active @endif">Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.product_categories.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.product_categories.create') active @endif">Create new Product Category</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/products*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#products" role="button" aria-expanded="false"
            aria-controls="products">
            <i class="link-icon" data-feather="package"></i>
            <span class="link-title">Products</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/products*')) show @endif" id="products">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.products.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.products.index') active @endif">Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.products.create') active @endif">Create new Product</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/asset*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#assets" role="button" aria-expanded="false"
            aria-controls="assets">
            <i class="link-icon" data-feather="pen-tool"></i>
            <span class="link-title">Asset Management</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/asset*')) show @endif" id="assets">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.assets.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.assets.index') active @endif">Overview</a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('admin.asset_categories.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.asset_categories.index') active @endif">Asset Categories</a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('admin.asset_categories.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.asset_categories.create') active @endif">Create a new Asset Category</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.assets.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.assets.create') active @endif">Create new Asset</a>
                </li>
            </ul>
        </div>
    </li>

</ul>

<ul class="nav">
    <li class="nav-item nav-category">Main</li>
    <li class="nav-item  @if (Request::is('*/dashboard')) active @endif">
        <a href="/" class="nav-link">
            <i class="material-icons material-symbols-outlined">
                dashboard
            </i>
            <span class="link-title">Dashboard</span>
        </a>
    </li>
    <li class="nav-item nav-category">Human Resource</li>
    <li class="nav-item @if (Request::is('admin/admins*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#admins" role="button" aria-expanded="false"
            aria-controls="admins">
            <i class="material-icons material-symbols-outlined">
                admin_panel_settings
            </i>
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
    <li class="nav-item @if (Request::is('admin/departments*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#departments" role="button" aria-expanded="false"
            aria-controls="departments">
            <i class="material-icons material-symbols-outlined">
                workspaces
            </i>
            <span class="link-title">Departments</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/departments*')) show @endif" id="departments">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.departments.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.departments.index') active @endif">
                        Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.departments.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.departments.create') active @endif">
                        Create a new Department</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/designations*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#designations" role="button" aria-expanded="false"
            aria-controls="designations">
            <i class="material-icons material-symbols-outlined">
                work
            </i>
            <span class="link-title">Designations</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/designations*')) show @endif" id="designations">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.designations.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.designations.index') active @endif">
                        Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.designations.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.designations.create') active @endif">
                        Create a new Designation</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item  @if (Request::is('admin/responsibilities*')) active @endif">
        <a href="{{ route('admin.responsibilities.index') }}" class="nav-link">
            <i class="material-icons material-symbols-outlined">
                account_tree
            </i>
            <span class="link-title">Responsibilities</span>
        </a>
    </li>
    <li class="nav-item @if (Request::is('admin/employees*') || Request::is('admin/employee_contracts*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#emails" role="button" aria-expanded="false"
            aria-controls="emails">
            <i class="material-icons material-symbols-outlined">
                badge
            </i>
            <span class="link-title">Employees</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/employees*') || Request::is('admin/employee_contracts*')) show @endif" id="emails">
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
                <li class="nav-item">
                    <a href="{{ route('admin.employee_contracts.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_contracts.index') active @endif">View Employee Contracts</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.employee_contracts.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.employee_contracts.create') active @endif">Create an Employee
                        Contract</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/attendances*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#attendances" role="button" aria-expanded="false"
            aria-controls="attendances">
            <i class="material-icons material-symbols-outlined">
                free_cancellation
            </i>
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
    <li class="nav-item @if (Request::is('admin/fines*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#fines" role="button" aria-expanded="false"
            aria-controls="fines">
            <i class="material-icons material-symbols-outlined">
                money_off
            </i>
            <span class="link-title">Fines</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/fines*')) show @endif" id="fines">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.fines.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.fines.index') active @endif">Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.fines.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.fines.create') active @endif">Add Fine Records</a>
                </li>

            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/bonuses*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#bonuses" role="button" aria-expanded="false"
            aria-controls="bonuses">
            <i class="material-icons material-symbols-outlined">
                money_off
            </i>
            <span class="link-title">Bonuses</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/bonuses*')) show @endif" id="bonuses">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.bonuses.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.bonuses.index') active @endif">Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.bonuses.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.bonuses.create') active @endif">Add Bonus Records</a>
                </li>

            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/payrolls*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#payrolls" role="button" aria-expanded="false"
            aria-controls="payrolls">
            <i class="material-icons material-symbols-outlined">
                paid
            </i>
            <span class="link-title">Payroll</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/payrolls*')) show @endif" id="payrolls">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.payrolls.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.payrolls.index') active @endif">Overview</a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item nav-category">Supply Chain & Procurement</li>
    <li class="nav-item @if (Request::is('admin/product_categories*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#product_categories" role="button"
            aria-expanded="false" aria-controls="product_categories">
            <i class="material-icons material-symbols-outlined">
                inventory
            </i>
            <span class="link-title">Products</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/product_categories*')) show @endif" id="product_categories">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.products.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.products.index') active @endif">Overview</a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('admin.product_categories.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.product_categories.index') active @endif">Product Categories</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.product_categories.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.product_categories.create') active @endif">Create new Product
                        Category</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.products.create') active @endif">Create new Product</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.products.create') active @endif">Add Product Items</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/asset*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#assets" role="button" aria-expanded="false"
            aria-controls="assets">
            <i class="material-icons material-symbols-outlined">
                splitscreen
            </i>
            <span class="link-title">Assets</span>
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
                        class="nav-link @if (Route::currentRouteName() == 'admin.asset_categories.create') active @endif">Create a new Asset
                        Category</a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('admin.asset_subcategories.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.asset_subcategories.create') active @endif">New Asset Subcategory</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.assets.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.assets.create') active @endif">Create new Asset</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/uniforms*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#uniforms" role="button" aria-expanded="false"
            aria-controls="uniforms">
            <i class="material-icons material-symbols-outlined">
                checkroom
            </i>
            <span class="link-title">Uniforms</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/uniforms*')) show @endif" id="uniforms">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.uniforms.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.uniforms.index') active @endif">Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.uniforms.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.uniforms.create') active @endif">Create new Uniform
                        Description</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.uniform-items.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.uniforms.create') active @endif">Overview of Uniforms
                        Issued</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.uniform-items.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.uniforms.create') active @endif">Issue New Uniform</a>
                </li>
            </ul>
        </div>
    </li>


    <li class="nav-item nav-category">Event Management</li>
    <li class="nav-item @if (Request::is('admin/event-orders*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#event-orders" role="button" aria-expanded="false"
            aria-controls="event-orders">
            {{-- <i class="link-icon" data-feather="package"></i> --}}
            <i class="material-icons material-symbols-outlined">
                event_note
            </i>
            <span class="link-title">Event Orders</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/event-orders*')) show @endif" id="event-orders">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.event-orders.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.event-orders.index') active @endif">Overview</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.event-orders.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.event-orders.create') active @endif">Create new Event Order</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item @if (Request::is('admin/conference-halls*')) active @endif">
        <a class="nav-link" data-bs-toggle="collapse" href="#conference-halls" role="button" aria-expanded="false"
            aria-controls="conference-halls">
            {{-- <i class="link-icon" data-feather="package"></i> --}}
            <i class="material-icons material-symbols-outlined">
                emoji_transportation
            </i>
            <span class="link-title">Conference Halls</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse @if (Request::is('admin/conference-halls*')) show @endif" id="conference-halls">
            <ul class="nav sub-menu">
                <li class="nav-item ">
                    <a href="{{ route('admin.conference-halls.index') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.conference-halls.index') active @endif">List of Halls</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.conference-halls.create') }}"
                        class="nav-link @if (Route::currentRouteName() == 'admin.conference-halls.create') active @endif">Create new Hall</a>
                </li>
            </ul>
        </div>
    </li>

</ul>

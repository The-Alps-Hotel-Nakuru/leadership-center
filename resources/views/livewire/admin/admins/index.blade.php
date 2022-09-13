<div>
    <x-slot name="header">System Administrators</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex">
                <h4>List of Administrators</h4>
                <div class="flex-col ms-auto">
                    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                        <i data-feather="user-plus"></i>
                    </a>
                </div>
            </div>
            <div class=" card-body table-responsive">
                <table class="table table-light">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Administrator Type</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr class="">
                                <td scope="row">{{ $admin->id }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->role->title }}</td>
                                <td>
                                    <div class="d-flex flex-row justify-content-center">
                                        <div class="flex-col m-2">
                                            <a href="{{ route('admin.admins.edit', $admin->id) }}"
                                                class="btn btn-xs btn-secondary">
                                                <i data-feather="edit"></i>
                                            </a>
                                        </div>
                                        <div class="flex-col  m-2">
                                            <button class="btn btn-xs btn-danger"
                                                wire:click='delete({{ $admin->id }})'>
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div>
    <x-slot name="header">System Administrators</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex bg-transparent border-0">
                <h4>List of Administrators</h4>
                <div class="flex-col ml-auto">
                    <a wire:ignore data-bs-toggle="tooltip" data-bs-placement="left" title="Add a new Administrator"
                        href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i>
                    </a>
                </div>
            </div>
            <div class=" card-body table-responsive">
                <table class="table table-hover">
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
                        @foreach ($admins as $key => $admin)
                            <tr class="">
                                {{-- <td>{{ $admins->firstItem() + $key }}</td> --}}
                                <td>
                                    @if ($admins instanceof \Illuminate\Pagination\Paginator)
                                        {{ $admins->firstItem() + $key }}
                                    @else
                                        {{ $key + 1 }}
                                    @endif
                                </td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->role->title }}</td>
                                <td>
                                    <div class="d-flex flex-row justify-content-center">
                                        <div class="flex-col m-2">
                                            <a wire:ignore href="{{ route('admin.admins.edit', $admin->id) }}"
                                                class="btn btn-secondary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                        @if (auth()->user()->id != $admin->id)
                                            <div class="flex-col  m-2">
                                                <button wire:ignore class="btn btn-danger"
                                                    onclick="confirm('Are you sure you want to Delete this Administrator?')||event.stopImmediatePropagation()"
                                                    wire:click='delete({{ $admin->id }})'>
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- <div class="my-3"> {{ $admins->links() }}</div> --}}
        </div>
    </div>
</div>

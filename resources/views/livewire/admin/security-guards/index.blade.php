<div>
    <x-slot name="header">Securiy</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex bg-transparent border-0">
                <h4>List of Security Accounts</h4>
                <div class="flex-col ms-auto">
                    <a wire:ignore data-bs-toggle="tooltip" data-bs-placement="left" title="Add a new Administrator"
                        href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                        <i class="bi bi-person-add"></i>
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
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($security_guards as $key => $security_guard)
                            <tr class="">
                                {{-- <td>{{ $security_guards->firstItem() + $key }}</td> --}}
                                <td>
                                    @if ($security_guards instanceof \Illuminate\Pagination\Paginator)
                                        {{ $security_guards->firstItem() + $key }}
                                    @else
                                        {{ $key + 1 }}
                                    @endif
                                </td>
                                <td>{{ $security_guard->name }}</td>
                                <td>{{ $security_guard->email }}</td>
                                <td>
                                    <div class="d-flex flex-row justify-content-center">
                                        <div class="flex-col m-2">
                                            <a wire:ignore href="{{ route('admin.security_guards.edit', $security_guard->id) }}"
                                                class="btn btn-secondary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                        @if (auth()->user()->id != $security_guard->id)
                                            <div class="flex-col  m-2">
                                                <button wire:ignore class="btn btn-danger"
                                                    onclick="confirm('Are you sure you want to Delete this Security Guard?')||event.stopImmediatePropagation()"
                                                    wire:click='delete({{ $security_guard->id }})'>
                                                    <i class="bi bi-trash"></i>
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
            {{-- <div class="my-3"> {{ $security_guards->links() }}</div> --}}
        </div>
    </div>
</div>

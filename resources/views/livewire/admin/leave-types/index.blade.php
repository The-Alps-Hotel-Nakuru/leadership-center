<div>
    <x-slot:header>
        Leave Types
    </x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Leave Types Table</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Details</th>
                        <th>Number of Leaves</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaveTypes as $type)
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td>
                                <h4>{{ $type->title }}</h4>
                                <p>{{ $type->description }}</p>
                            </td>
                            <td>
                                {{ count($type->leaves) }}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-secondary" href="{{ route('admin.leave-types.edit', $type->id) }}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-danger" wire:click='delete({{ $type->id }})'>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

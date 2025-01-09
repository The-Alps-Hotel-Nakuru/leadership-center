<div>
    <x-slot:header>Employment Types</x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Employment Types List</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Rate Type</th>
                        <th>Penalizable</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employment_types as $type)
                        <tr>
                            <td scope="row">{{ $type->id }}</td>
                            <td>{{ $type->title }}</td>
                            <td style="max-width: 500px">{{ $type->description }}</td>
                            <td>{{ $type->rate_type }}</td>
                            <td>{!! $type->is_penalizable ? "<span class='text-success'>True</span>" : "<span class='text-danger'>False</span>" !!}</td>
                            <td class="d-flex flex-row justify-content-center">
                                <a href="{{ route('admin.employment-types.edit', $type->id) }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Employment Type"
                                    class="btn btn-secondary m-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button
                                    onclick="confirm('Are you sure you want to Delete this Employment Type?')||event.stopImmediatePropagation()"
                                    wire:click="delete({{ $type->id }})" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Delete Employment Type" class="btn btn-danger m-1">
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

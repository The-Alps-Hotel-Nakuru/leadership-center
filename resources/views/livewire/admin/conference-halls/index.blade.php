<div>
    <x-slot name="header">
        Conference Halls
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header ">
                <h5>List of Conference Halls </h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Location</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($halls as $hall)
                            <tr class="">
                                <td scope="row">{{ $hall->id }}</td>
                                <td>{{ $hall->name }}</td>
                                <td>{{ $hall->location->name }}</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <div class="flex-col m-2">
                                        <a href="{{ route('admin.conference-halls.edit', $hall->id) }}" class="btn btn-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                    <div class="flex-col m-2">
                                        <button class="btn btn-danger" wire:click="delete({{ $hall->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
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

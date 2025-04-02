<div>
    <x-slot:header>Holidays</x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>List of Holidays Added</h5>
        </div>
        <div class="card-body table-responsive">
            @if ($holidays->count() > 0)
                <table class="table table-hover">
                    <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($holidays as $holiday)
                            <tr>
                                <td scope="row">{{ $holiday->id }}</td>
                                <td>{{ $holiday->name }}</td>
                                <td>{{ Carbon\Carbon::parse($holiday->date)->format('jS F, Y') }}</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <div class="flex-col mx-1">
                                        <a href="{{ route('admin.holidays.edit', $holiday->id) }}"
                                            class="btn btn-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                    <div class="flex-col mx-1">
                                        <button wire:click='delete({{ $holiday->id }})' class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h1 class="text-center my-3">No Holidays Added</h1>
            @endif
        </div>
    </div>
</div>

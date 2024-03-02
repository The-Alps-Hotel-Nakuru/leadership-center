<div>
    <x-slot:header>Bans</x-slot:header>

    <div class="card">
        <div class="card-header bg-transparent border-0">
            <h5>List of Banned Employees</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Employee's Name</th>
                            <th scope="col">Reason for Ban</th>
                            <th scope="col">Date of Ban</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bans as $ban)
                            <tr class="">
                                <td scope="row">{{ $ban->id }}</td>
                                <td>{{ $ban->employee->id }}</td>
                                <td>{{ $ban->employee->user->name }}</td>
                                <td>{{ $ban->reason }}</td>
                                <td>{{ Carbon\Carbon::parse($ban->created_at)->format('jS F, Y H:i \h\r\s') }}</td>
                                <td class="d-flex flex-row">
                                    <div class="flex-col">
                                        <button onclick="confirm('Are you sure you want to unban this Employee?')||event.stopImmediatePropagation()" wire:click='unban({{ $ban->id }})' class="btn btn-xs btn-dark">Unban Employee</button>
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

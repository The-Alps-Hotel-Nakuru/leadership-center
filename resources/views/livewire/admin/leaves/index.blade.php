<div>

    <x-slot:header>
        List of Leaves Given ({{ count($leaves) }})
    </x-slot:header>

    <div class="card">
        @if (count($leaves) > 0)
            <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Employee's Name</th>
                            <th scope="col">Leave Type</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaves as $leave)
                            <tr class="">
                                <td scope="row">{{ $leave->id }}</td>
                                <td scope="row">{{ $leave->employee->user->name }}</td>
                                <td scope="row">{{ $leave->type->title}}</td>
                                <td>{{ Carbon\Carbon::parse($leave->start_date)->format('jS F,Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($leave->end_date)->format('jS F,Y') }}</td>
                                <td>
                                    <div class="d-flex flex-row">
                                        <div class="flex-col">
                                            <a href="" class="btn btn-secondary"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        @else
            <div class="my-5">
                <h3 class="text-center">No Leave has been issued</h3>
            </div>
        @endif
    </div>
</div>

<div>
    <x-slot:header>My Leave Requests</x-slot:header>

    <div class="row mb-5">
        @foreach (App\Models\LeaveType::all() as $type)
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header border-0 bg-transparent">
                        <h5>{{ $type->title }}</h5>
                    </div>
                    <div class="card-body">
                        Max Days Allocated <small style="font-size: 9px">(per annum)</small>
                        <h6>
                            <strong>{{ $type->max_days ? $type->max_days . ' days' : 'N/A' }} </strong>
                        </h6>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card table-responsive">
        <div class="card-header d-flex">
            <h5>My Leave Requests</h5>
            <a href="{{ route('employee.leave-requests.create') }}" class="btn btn-xs btn-secondary ml-auto"><i
                    class="fas fa-plus"></i> New Leave Request</a>
        </div>
        <table class="table table-hover ">
            <thead class="">
                <tr>
                    <th>ID</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reporting Back</th>
                    <th>No. Of Days Requested</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($leaveRequests)
                    @foreach ($leaveRequests as $request)
                        <tr>
                            <td scope="row">{{ $request->id }}</td>
                            <td>{{ $request->leave_type->title }}</td>
                            <td>{{ Carbon\Carbon::parse($request->start_date)->format('jS F,Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($request->end_date)->format('jS F,Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($request->end_date)->addDay()->format('jS F,Y') }}</td>
                            <td>{{ $request->days_requested }}</td>
                            <td>{!! $request->status !!} </td>
                            <td class="d-flex flex-row justify-content-center">
                                <div class="flex-col mx-2">
                                    <a href="{{ route('employee.leave-requests.edit', $request->id) }}"
                                        class="btn btn-secondary"><i class="fas fa-edit"></i></a>
                                </div>
                                {{-- <div class="flex-col mx-2">
                                    <button class="btn btn-danger"
                                        onclick="confirm('Are you Sure You want to delete the Leave Request?')||event.stopImmediatePropagation()"
                                        wire:click="delete({{ $request->id }})"><i class="fas fa-trash"></i></button>
                                </div> --}}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <h1 class="text-center my-3">The Are no Leave Requests Made</h1>
                @endif
            </tbody>
        </table>
        {{ $leaveRequests->links() }}
    </div>
</div>

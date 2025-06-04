<div>
    <x-slot:header>Leave Requests</x-slot:header>

    <div class="card my-5">
        <div class="card-header">
            <h5>Pending Requests</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover ">
                <thead class="">
                    <tr>
                        <th>ID</th>
                        <th>Employee's Name</th>
                        <th>Requested type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Reporting Back</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($leave_requests as $leave_request)
                        @if ($leave_request->is_pending)
                            <tr>
                                <td scope="row">{{ $leave_request->id }}</td>
                                <td>{{ $leave_request->employee->user->name }}</td>
                                <td>{{ $leave_request->leave_type->title }}</td>
                                <td>{{ Carbon\Carbon::parse($leave_request->start_date)->format('jS F, Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($leave_request->end_date)->format('jS F, Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($leave_request->end_date)->addDay()->format('jS F, Y') }}
                                </td>
                                <td>{{ $leave_request->reason }}</td>
                                <td>{!! $leave_request->status !!}</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <div class="flex-col mx-2">
                                        <a href="{{ route('admin.leave-requests.approve', $leave_request->id) }}"
                                            class="btn btn-success"><i class="bi bi-check"></i></a>
                                    </div>
                                    <div class="flex-col mx-2">
                                        <button class="btn btn-danger"
                                            onclick="confirm('Are you Sure You want to Reject the Leave Request?')||event.stopImmediatePropagation()"
                                            wire:click="reject({{ $leave_request->id }})"><i
                                                class="bi bi-x"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Approved Requests</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover ">
                        <thead class="">
                            <tr>
                                <th>ID</th>
                                <th>Employee's Name</th>
                                <th>Requested type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Reporting Back</th>
                                <th>Reason</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($leave_requests as $leave_request)
                                @if ($leave_request->is_approved)
                                    <tr>
                                        <td scope="row">{{ $leave_request->id }}</td>
                                        <td>{{ $leave_request->employee->user->name }}</td>
                                        <td>{{ $leave_request->leave_type->title }}</td>
                                        <td>{{ Carbon\Carbon::parse($leave_request->start_date)->format('jS F, Y') }}
                                        </td>
                                        <td>{{ Carbon\Carbon::parse($leave_request->end_date)->format('jS F, Y') }}
                                        </td>
                                        <td>{{ Carbon\Carbon::parse($leave_request->end_date)->addDay()->format('jS F, Y') }}
                                        </td>
                                        <td>{{ $leave_request->reason }}</td>
                                        <td>{!! $leave_request->status !!}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Approved Requests</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover ">
                        <thead class="">
                            <tr>
                                <th>ID</th>
                                <th>Employee's Name</th>
                                <th>Requested type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Reporting Back</th>
                                <th>Reason</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($leave_requests as $leave_request)
                                @if ($leave_request->is_rejected)
                                    <tr>
                                        <td scope="row">{{ $leave_request->id }}</td>
                                        <td>{{ $leave_request->employee->user->name }}</td>
                                        <td>{{ $leave_request->leave_type->title }}</td>
                                        <td>{{ Carbon\Carbon::parse($leave_request->start_date)->format('jS F, Y') }}
                                        </td>
                                        <td>{{ Carbon\Carbon::parse($leave_request->end_date)->format('jS F, Y') }}
                                        </td>
                                        <td>{{ Carbon\Carbon::parse($leave_request->end_date)->addDay()->format('jS F, Y') }}
                                        </td>
                                        <td>{{ $leave_request->reason }}</td>
                                        <td>{!! $leave_request->status !!}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

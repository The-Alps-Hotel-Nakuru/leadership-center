<div class="card">
    <div class="card-header">
        <h5>Event Log</h5>
    </div>
    <div class="table-responsive card-body" style="max-height: 450px">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">User</th>
                    <th scope="col">Activity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr class="">
                        <td scope="row">{{ $log->id }}</td>
                        <td colspan="1">{!! $log->payload !!}</td>
                        <td>
                            {{ Carbon\Carbon::parse($log->created_at)->format('jS F, Y h:i:sA ') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $logs->links(data: ['scrollTo' => false]) }}
    </div>
</div>

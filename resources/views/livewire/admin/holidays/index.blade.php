<div>
    <x-slot:header>Holidays</x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>List of Holidays Added</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead class="">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($holidays as $holiday)
                        <tr>
                            <td scope="row">{{ $holiday->id }}</td>
                            <td>{{ $holiday->name }}</td>
                            <td>{{ Carbon\Carbon::parse($holiday->date)->format('jS F, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

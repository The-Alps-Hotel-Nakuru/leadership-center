<div>
    <x-slot:header>My Contracts</x-slot:header>
    <div class="row">
        @foreach (auth()->user()->employee->contracts()->orderBy('end_date', 'desc')->get() as $contract)
            <div class="col-md-3">
                <div class="card shadow">
                    <div class="card-header border-0 bg-transparent">
                        Contract Status:
                        <h5>{!! $contract->is_active
                            ? '<strong class="text-success">Active</strong>'
                            : '<strong class="text-danger">Inactive</strong>' !!}</h5>
                    </div>
                    <div class="card-body row m-3">
                        <div class="list-group-item col-6"><strong>Contract ID:</strong> {{ $contract->id }}</div>
                        <div class="list-group-item col-6"><strong>Employee ID:</strong>
                            {{ $contract->employees_detail_id }}</div>
                        <div class="list-group-item col-6"><strong>Designation:</strong>
                            {{ $contract->designation->title }}</div>

                        <div class="list-group-item col-6"><strong>Start Date:</strong>
                            {{ Carbon\Carbon::parse($contract->start_date)->format('jS F, Y') }}</div>
                        <div class="list-group-item col-6"><strong>End Date:</strong>
                            {{ Carbon\Carbon::parse($contract->end_date)->format('jS F, Y') }}</div>
                        <div class="list-group-item col-4"><strong>Employment Type:</strong>
                            {{ $contract->employment_type->title }}</div>
                        <div class="list-group-item col-4"><strong>Weekly Offs:</strong>
                            {{ $contract->weekly_offs }}
                        </div>
                        <div class="list-group-item col-4"><strong>Is Taxable:</strong>
                            {{ $contract->is_taxable ? 'Yes' : 'No' }}</div>


                        <div class="list-group-item col-12 text-center text-white bg-dark"
                            style="font-size:18px; font:black"><strong>Salary (KES):</strong>
                            {{ number_format($contract->salary_kes) }}
                            {{ $contract->employment_type->rate_type }}</div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

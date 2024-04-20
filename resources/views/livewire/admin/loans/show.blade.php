<div>
    <x-slot:header>
        Loans
    </x-slot:header>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>List of Loan Deductions for Loan #{{ $loan->id }}</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Month of Deduction</th>
                            <th>Deduction Amount</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loan->loan_deductions as $deduction)
                            <tr>
                                <td scope="row">{{ $deduction->id }}</td>
                                <td>{{ Carbon\Carbon::parse($deduction->year.'-'.$deduction->month)->format('F, Y') }}</td>
                                <td><small>KES </small> <strong>{{ number_format($deduction->amount,2) }}</strong></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div>
    <x-slot:header>
        Loans
    </x-slot:header>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>List of Headers</h5>
            </div>
            <div class="table-responsive card-body">
                @if (count($loans) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Amount</th>
                                <th scope="col">First Repayment Month</th>
                                <th scope="col">Number of Repayments</th>
                                <th scope="col">Deductions Total</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Date Issued</th>
                                <th class="text-center" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loans as $loan)
                                <tr class="">
                                    <td scope="row">{{ $loan->id }}</td>
                                    <td>{{ $loan->employee->user->name }}</td>
                                    <td><small>KES </small> <strong>{{ number_format($loan->amount, 2) }}</strong></td>
                                    <td>{{ Carbon\Carbon::parse($loan->year . '-' . $loan->month)->format('F, Y') }}
                                    </td>
                                    <td>{{ count($loan->loan_deductions) }} months</td>
                                    <td>KES {{ number_format($loan->total_amount, 2) }}</td>
                                    <td>KES {{ number_format($loan->balance, 2) }}</td>
                                    <td>{{ Carbon\Carbon::parse($loan->created_at)->format('jS F, Y h:i A') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.loans.show', $loan->id) }}" class="btn btn-secondary">
                                            <i class="bi bi-list"></i>
                                        </a>
                                        <button
                                            onclick="confirm('Are you sure you want to delete this Loan Record?')||event.stopImmediatePropagation()"
                                            wire:click='delete({{ $loan->id }})' class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $loans->links() }}
                @else
                    <div class="my-5">
                        <h3 class="text-center">No Loans have been issued</h3>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<div>
    <x-slot:header>
        Loans
    </x-slot:header>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>List of Loan Deductions for Loan #{{ $loan->id }}</h5>
                @if ($loan->unsettled_balance > 0)
                    <a href="{{ route('admin.loan_deductions.create', [$loan->id]) }}" class="btn btn-primary ms-auto">
                    <i class="bi bi-plus"></i>
                    Create Deduction
                </a>
                @else
                    <a href="#" class="btn btn-secondary disabled ms-auto">
                        <i class="bi bi-plus"></i>
                        Create Deduction
                    </a>
                @endif
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
                                <td>{{ Carbon\Carbon::parse($deduction->year . '-' . $deduction->month)->format('F, Y') }}
                                </td>
                                <td class="@if ($deduction->is_settled) text-success @endif"><small>KES </small>
                                    <strong>{{ number_format($deduction->amount, 2) }}</strong> <br>
                                    @if ($deduction->is_settled)
                                        <small>SETTLED</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (!$deduction->is_settled)
                                        <a href="{{ route('admin.loan_deductions.edit', [$loan->id, $deduction->id]) }}"
                                            class="btn btn-secondary">
                                            <i class="bi bi-list"></i>
                                        </a>
                                        <button
                                            onclick="confirm('Are you sure you want to delete this Loan Deduction Record?')||event.stopImmediatePropagation()"
                                            wire:click='delete({{ $deduction->id }})' class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        <tr class="@if ($loan->unsettled_balance > 0) table-danger border-danger @else table-success border-success @endif  border-2">
                            <td colspan="2">Total Unsettled Balance</td>
                            <td><strong>KES {{ number_format($loan->unsettled_balance, 2) }}</strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

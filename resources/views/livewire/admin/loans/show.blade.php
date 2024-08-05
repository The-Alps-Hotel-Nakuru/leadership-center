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
                                <td>{{ Carbon\Carbon::parse($deduction->year . '-' . $deduction->month)->format('F, Y') }}
                                </td>
                                <td class="@if ($deduction->is_settled) text-success @endif"><small>KES </small>
                                    <strong>{{ number_format($deduction->amount, 2) }}</strong> <br>@if ($deduction->is_settled) <small>SETTLED</small>  @endif</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <div class="flex-col mx-1">
                                        <a href="{{ route('admin.loan_deductions.edit', [$loan->id, $deduction->id]) }}"
                                            class="btn btn-secondary">
                                            <i class="fas fa-list"></i>
                                        </a>
                                    </div>
                                    <div class="flex-col mx-1">
                                        <button
                                            onclick="confirm('Are you sure you want to delete this Loan Deduction Record?')||event.stopImmediatePropagation()"
                                            wire:click='delete({{ $deduction->id }})' class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
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

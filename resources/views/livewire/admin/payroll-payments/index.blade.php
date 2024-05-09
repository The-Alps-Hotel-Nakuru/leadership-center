<div>
    <x-slot:header>
        Payroll Payments
    </x-slot:header>

    <div class="container-fluid">
        <div class="row">
            @if ($payrolls)
                @foreach ($payrolls as $payroll)
                    @if ($payroll->payments->count() > 0)
                        <div class="col-2">
                            <a href="{{ route('admin.payroll_payments.show', $payroll->id) }}" class="btn card">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        {{ Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->format('F, Y') }}
                                    </h3>
                                    <p class="card-text">
                                    <h5><small>KES </small>{{ number_format($payroll->gross_payments_total) }}</h5>
                                    <p>
                                </div>
                            </a>
                            @if ($payroll->payment_slip_path)
                                <a target="_blank" href="{{ asset($payroll->payment_slip_path) }}" class="btn btn-dark">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                @endforeach
            @endif


        </div>

    </div>
</div>

<div>
    <x-slot:header>
        Payroll Payments
    </x-slot:header>

    <div class="container-fluid">
        <div class="row">
            @if ($payrolls)
                @foreach ($payrolls as $payroll)
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
                    </div>
                @endforeach
            @endif


        </div>

    </div>
</div>

<div>
    {{-- Do your work, then step back. --}}
    <x-slot:header>Payrolls</x-slot:header>

    <div class="card">
        <div class="card-header d-flex">
            <h5>Upload File for Payroll ({{ $payroll->yearmonth }})</h5>

            @if ($payroll->payment_slip_path)
                <button class="btn btn-dark ms-auto" wire:click='removePaymentSlip'>Remove Payments File</button>
            @endif

        </div>
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="">Payment Slip</label>
                <input type="file" wire:model.live='payment_slip' class="form-control" name="" id=""
                    aria-describedby="helpId" placeholder="">
                @error('payment_slip')
                    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button wire:click='save' class="btn btn-dark">Save</button>
        </div>

    </div>

    @if ($payroll->payment_slip_path)
        <div class="card">
            <div class="card-header">
                <h5>Current Document</h5>
            </div>
            <div class="card-body" style="height: 500px">
                <iframe src="{{ asset($payroll->payment_slip_path) }}" type="application/pdf" width="100%"
                    height="100%"></iframe>

            </div>
        </div>
    @endif
</div>

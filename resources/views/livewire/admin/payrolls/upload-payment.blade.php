<div>
    {{-- Do your work, then step back. --}}
    <x-slot:header>Payrolls</x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Upload File for Payroll ({{ $payroll->yearmonth }})</h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="">Payment Slip</label>
                <input type="file" wire:model='payment_slip' class="form-control" name="" id="" aria-describedby="helpId"
                    placeholder="">
                @error('payment_slip')
                    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button wire:click='upload' class="btn btn-primary">Save</button>
        </div>
    </div>
</div>

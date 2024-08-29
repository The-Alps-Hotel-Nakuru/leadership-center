<div class="card">
    <div class="card-header">
        <h3 class="card-title">Generate P9 Form</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
              <label for="year">Year</label>
              <input type="number" step="1" min="2022" wire:model="year"
                class="form-control" name="year" id="year" aria-describedby="helpId" placeholder="">
              @error('year')
                  <small id="helpId" class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
        </div>
        <button wire:click="generateP9Form" class="btn btn-primary">Generate P9 Form</button>

        @if($p9Data)
            <div class="mt-4">
                <h5>P9 Form Details</h5>
                <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                <p><strong>PIN:</strong> {{ $p9Data['employee_pin'] }}</p>
                <p><strong>Total Earnings:</strong> {{ number_format($p9Data['total_earnings'], 2) }}</p>
                <p><strong>Total NSSF:</strong> {{ number_format($p9Data['total_nssf'], 2) }}</p>
                <p><strong>Total NHIF:</strong> {{ number_format($p9Data['total_nhif'], 2) }}</p>
                <p><strong>Total Affordable Housing Levy:</strong> {{ number_format($p9Data['total_ahl'], 2) }}</p>
                <p><strong>Total NITA:</strong> {{ number_format($p9Data['total_nita'], 2) }}</p>
                <p><strong>Tax Paid:</strong> {{ number_format($p9Data['total_paye'], 2) }}</p>
                <!-- Add other necessary fields -->
                <button class="btn btn-success mt-2" wire:click="downloadP9Form({{ collect($p9Data) }})">Download P9 Form</button>
            </div>
        @endif
    </div>
</div>

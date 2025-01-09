<div>
    <x-slot:header>
        Create Advances
    </x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Create a new Advance Record</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <input type="text" class="form-control" wire:model.live="search" placeholder="Search employees">
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <ul class="list-group mt-2 w-100">
                            @if ($search != '')
                                @foreach ($employees as $employee)
                                        <li wire:click="selectEmployee({{ $employee->id }})"
                                            class="list-group-item {{ $selectedEmployee == $employee->id ? 'active' : '' }}">
                                            {{ $employee->user->name }}
                                        </li>
                                @endforeach
                            @endif
                        </ul>
                        @error('selectedEmployee')
                            <small id="time" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Month</label>
                        <input wire:model.live="yearmonth" type="month" class="form-control" name="time"
                            id="time" aria-describedby="time" placeholder="Enter the Month Advanced For">
                        @error('yearmonth')
                            <small id="time" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="amount_kes" class="form-label">Amount</label>
                        <input wire:model.live="advance.amount_kes" type="number" min="1" step="0.05" class="form-control" name="time"
                            id="time" aria-describedby="time" placeholder="Enter the Amount Applied For in KES">
                        @error('advance.amount_kes')
                            <small id="time" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="transaction" class="form-label">Transaction Code</label>
                        <input wire:model.live="advance.transaction" type="text"  class="form-control" name="transaction"
                            id="time" aria-describedby="time" placeholder="Enter the Transaction Code">
                        @error('advance.transaction')
                            <small id="time" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea wire:model.live="advance.reason"   class="form-control" name="reason"
                            id="time" aria-describedby="time" placeholder="Enter the reason"></textarea>
                        @error('advance.reason')
                            <small id="time" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <button wire:click="save" class="btn btn-dark text-uppercase">Save</button>
        </div>
    </div>
</div>

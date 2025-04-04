<div>
<x-slot:header>
    Welfare Contributions Overview
</x-slot:header>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Edit this Welfare Contribution Record for an Employee</h5>
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
                                            class="list-group-item {{ $welfare_contribution->employees_detail_id == $employee->id ? 'active' : '' }}">
                                            {{ $employee->user->name }}
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            @error('welfare_contribution.employees_detail_id')
                                <small id="time" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="month" class="form-label">Month and Year</label>
                            <input type="month" wire:model.live="yearmonth" class="form-control" name="month"
                                id="month" aria-describedby="helpId" placeholder="Enter your month and year">
                            @error('yearmonth')
                                <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="Amount" class="form-label">Amount (KES)</label>
                            <input wire:model.live='welfare_contribution.amount_kes' type="number" class="form-control" name="Amount"
                                id="Amount" aria-describedby="helpId" placeholder="Enter the amount of Money">
                            @error('welfare_contribution.amount_kes')
                                <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="welfare_contribution.reason" class="form-label">Reason for Fine</label>
                            <textarea wire:model.live="welfare_contribution.reason" class="form-control" name="welfare_contribution.reason" id="welfare_contribution.reason" rows="3"></textarea>
                            @error('welfare_contribution.reason')
                                <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.welfare_contributions.index') }}" class="btn btn-warning">BACK</a>
                <button wire:click="save" class="btn btn-dark">SAVE</button>
            </div>
        </div>
    </div>
</div>

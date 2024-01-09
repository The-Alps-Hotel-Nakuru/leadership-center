<div>
    <x-slot:header>New Bonus Record</x-slot:header>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Create a new Bonus Record for an Employee</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <input type="text" class="form-control" wire:model="search" placeholder="Search employees">
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <ul class="list-group mt-2 w-100">
                                @if ($search != '')
                                    @foreach ($employees as $employee)
                                        <li wire:click="selectEmployee({{ $employee->id }})"
                                            class="list-group-item {{ $bonus->employees_detail_id == $employee->id ? 'active' : '' }}">
                                            {{ $employee->user->name }}
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            @error('bonus.employees_detail_id')
                                <small id="time" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="month" class="form-label">Month and Year</label>
                            <input type="month" wire:model="yearmonth" class="form-control" name="month"
                                id="month" aria-describedby="helpId" placeholder="Enter your month and year">
                            @error('yearmonth')
                                <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="Amount" class="form-label">Amount (KES)</label>
                            <input wire:model='bonus.amount_kes' type="number" class="form-control" name="Amount"
                                id="Amount" aria-describedby="helpId" placeholder="Enter the amount of Money">
                            @error('bonus.amount_kes')
                                <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="bonus.reason" class="form-label">Reason for Bonus</label>
                            <textarea wire:model="bonus.reason" class="form-control" name="bonus.reason" id="bonus.reason" rows="3"></textarea>
                            @error('bonus.reason')
                                <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <button wire:click="save" class="btn btn-dark">SAVE</button>
            </div>
        </div>
    </div>
</div>

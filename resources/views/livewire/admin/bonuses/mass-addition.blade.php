<div>
    <x-slot:header>
        Mass Addition of Bonuses
        </x-slot>

        <div class="card">
            <div class="card-header">
                <h5>Upload Bonuses Data</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="" class="form-label">File Upload</label>
                    <input type="file" name="employee_bonuses" class="form-control" wire:model='employee_bonuses'>
                    @error('employee_bonuses')
                        <small id="helpId" class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="validateData"
                    wire:click="validateData">
                    <span wire:loading.remove wire:target="validateData">
                        Check Data
                    </span>
                    <span wire:loading wire:target="validateData">
                        Checking...
                    </span>
                </button>
            </div>
        </div>

        @if ($bonuses)
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Bonuses Data</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-borderless align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Amount</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bonuses as $bonus)
                                <tr>
                                    <td>{{ $bonus['id'] }}</td>
                                    <td>{{ $bonus['first_name'] }}</td>
                                    <td>{{ $bonus['last_name'] }}</td>
                                    <td>{{ $bonus['year'] }}</td>
                                    <td>{{ $bonus['month'] }}</td>
                                    <td>{{ $bonus['amount_kes'] }}</td>
                                    <td>{{ $bonus['reason'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
</div>

</div>

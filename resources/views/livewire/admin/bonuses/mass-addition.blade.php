<div>
    <x-slot:header>
        Mass Addition of Bonuses
        </x-slot>

        <div class="card">
            <div class="card-header">
                <h5>Upload Employee Bonuses</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="" class="form-label">File Upload</label>
                    <input type="file" name="employee_bonuses_file" class="form-control"
                        wire:model='employee_bonuses_file'>
                    @error('employee_bonuses_file')
                        <small class="text-danger">{{ $message }}</small>
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
                                        <th>National ID</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($bonuses as $bonus)
                                        <tr>
                                            <td>{{ $bonus['ID'] }}</td>
                                            <td>{{ $bonus['FIRST_NAME'] }}</td>
                                            <td>{{ $bonus['LAST_NAME'] }}</td>
                                            <td>{{ $bonus['YEAR'] }}</td>
                                            <td>{{ $bonus['MONTH'] }}</td>
                                            <td>{{ $bonus['AMOUNT'] }}</td>
                                            <td>{{ $bonus['NATIONAL_ID'] }}</td>
                                            <td>{{ $bonus['REASON'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-2">
                                <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="uploadBonuses"
                                    wire:click="uploadBonuses">
                                    <span wire:loading.remove wire:target="uploadBonuses">
                                        Upload Bonuses
                                    </span>
                                    <span wire:loading wire:target="uploadBonuses">
                                        Uploading...
                                    </span>
                                </button>
                            </div>
                        </div>
              
                    </div>
                </div>
            </div>
        @else
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
                                        <th>National ID</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td colspan="8">No Bonuses To Upload</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
</div>
</div>

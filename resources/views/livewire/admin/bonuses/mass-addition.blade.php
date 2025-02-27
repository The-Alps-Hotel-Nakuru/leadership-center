<div>
    <x-slot:header>
        Mass Addition of Bonuses
    </x-slot>



    <div class="card">
        <div class="card-header">
            <h5>Upload Employee Bonuses</h5>
            <button class="btn btn-secondary ml-auto mr-2" wire:loading.attr="disabled" wire:target="downloadTemplate"
                wire:click="downloadTemplate">
                <span wire:loading.remove wire:target="downloadTemplate">
                    Download Bonuses Template
                </span>
                <span wire:loading wire:target="downloadTemplate">
                    Downloading...
                </span>
            </button>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="" class="form-label">File Upload</label>
                <input type="file" name="employee_bonuses_file" class="form-control"
                    wire:model.live='employee_bonuses_file'>
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
                                    <th>National ID</th>
                                    <th>Full Name</th>
                                    <th>email</th>
                                    <th>Month Effected</th>
                                    <th>Amount</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($bonuses as $bonus)
                                    @php
                                        $employee = App\Models\EmployeesDetail::where(
                                            'national_id',
                                            $bonus[1],
                                        )->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $bonus[0] }}</td>
                                        <td>{{ $bonus[1] }}</td>
                                        <td>{{ $employee->user->name }}</td>
                                        <td>{{ $employee->user->email }}</td>
                                        <td>{{ Carbon\Carbon::parse($bonus[4] . '-' . $bonus[5])->format('F, Y') }}</td>
                                        <td><small>KES
                                            </small><strong>{{ number_format($bonus[6], 2) }}</strong>
                                        </td>
                                        <td>{{ $bonus[7] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-2">
                            <button
                                onclick="confirm('Are you sure you want to Upload these Bonuses? This action is not reversible')||event.stopImmediatePropagation()"
                                class="btn btn-primary" wire:loading.attr="disabled" wire:target="uploadBonuses"
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
                                    <th>Email</th>
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

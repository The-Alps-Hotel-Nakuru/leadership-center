<div>
    <x-slot:header>
        Mass Addition of Fines
        </x-slot>

        <div class="card">
            <div class="card-header">
                <h5>Upload Employee Fines</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="" class="form-label">File Upload</label>
                    <input type="file" name="employee_finess_file" class="form-control" wire:model='employee_fines_file'>
                    @error('employee_fines_file')
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

        @if ($fines)
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Fines Data</h5>
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

                                    @foreach ($fines as $fine)
                                        <tr>
                                            <td>{{ $fine['ID'] }}</td>
                                            <td>{{ $fine['FIRST_NAME'] }}</td>
                                            <td>{{ $fine['LAST_NAME'] }}</td>
                                            <td>{{ $fine['YEAR'] }}</td>
                                            <td>{{ $fine['MONTH'] }}</td>
                                            <td>{{ $fine['AMOUNT'] }}</td>
                                            <td>{{ $fine['NATIONAL_ID'] }}</td>
                                            <td>{{ $fine['REASON'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-2">
                                <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="uploadFines"
                                    wire:click="uploadFines">
                                    <span wire:loading.remove wire:target="uploadFines">
                                        Upload Fines
                                    </span>
                                    <span wire:loading wire:target="uploadFines">
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
                            <h5>Fines Data</h5>
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
                                        <td colspan="8">No Fines To Upload</td>
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

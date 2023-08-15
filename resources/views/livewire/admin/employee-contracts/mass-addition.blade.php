<div>
    <x-slot:header>
        Mass Addition of Contracts
    </x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Upload Contracts File</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="" class="form-label">Mass Contracts Upload</label>
                <input type="file" wire:model='contractsFile' class="form-control" name="" id=""
                    aria-describedby="helpId" placeholder="">
                @error('contractsFile')
                    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="checkData" wire:click="checkData">
                <span wire:loading.remove wire:target="checkData">
                    Check Data
                </span>
                <span wire:loading wire:target="checkData">
                    Checking...
                </span>
            </button>
        </div>
    </div>
    <div class="mt-3"></div>
    <div class="row">
        @if ($validContracts)
            <div class="col-md-4 col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5><strong>Ready Contracts</strong></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Contract Type</th>
                                        <th scope="col">Starting Date</th>
                                        <th scope="col">Ending Date</th>
                                        <th scope="col">Salary/Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($validContracts as $contract)
                                        <tr class="">
                                            <td scope="row">{{ $contract[0] }}</td>
                                            <td scope="row">{{ App\Models\User::find($contract[0])->name }}</td>
                                            <td scope="row">{{ App\Models\Designation::find($contract[1])->title }}
                                            <td scope="row">
                                                {{ App\Models\EmploymentType::find($contract[2])->title }}
                                            </td>
                                            <td scope="row">
                                                {{ Carbon\Carbon::parse($contract[3])->format('jS F,Y') }}
                                            </td>
                                            <td scope="row">
                                                {{ Carbon\Carbon::parse($contract[4])->format('jS F,Y') }}
                                            </td>
                                            <td scope="row">{{ number_format($contract[5], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-primary" wire:click="uploadContracts">Upload Contracts</button>

                    </div>
                </div>
            </div>
        @endif
        @if ($alreadyExisting)
            <div class="col-md-4 col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5><strong>Already Active</strong></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Contract Type</th>
                                        <th scope="col">Starting Date</th>
                                        <th scope="col">Ending Date</th>
                                        <th scope="col">Salary/Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alreadyExisting as $contract)
                                        <tr class="">
                                            <td scope="row">{{ $contract[0] }}</td>
                                            <td scope="row">{{ App\Models\User::find($contract[0])->name }}</td>
                                            <td scope="row">{{ App\Models\Designation::find($contract[1])->title }}
                                            <td scope="row">
                                                {{ App\Models\EmploymentType::find($contract[2])->title }}
                                            </td>
                                            <td scope="row">
                                                {{ Carbon\Carbon::parse($contract[3])->format('jS F,Y') }}
                                            </td>
                                            <td scope="row">
                                                {{ Carbon\Carbon::parse($contract[4])->format('jS F,Y') }}
                                            </td>
                                            <td scope="row">{{ number_format($contract[5], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        @endif
        @if ($invalidContracts)
            <div class="col-md-4 col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5><strong>Invalid Contracts</strong></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        {{-- <th scope="col">User ID</th> --}}
                                        <th scope="col">Name</th>
                                        <th scope="col">Contract Type</th>
                                        <th scope="col">Starting Date</th>
                                        <th scope="col">Ending Date</th>
                                        <th scope="col">Salary/Rate</th>
                                        <th scope="col">Reason for Invalidity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invalidContracts as $contract)
                                        <tr class="">
                                            {{-- <td scope="row">{{ $contract[0] }}</td> --}}
                                            <td scope="row">{{ $contract[0] }}</td>
                                            <td scope="row">
                                                {{ App\Models\EmploymentType::find($contract[1])->title }}
                                            </td>
                                            <td scope="row">
                                                {{ Carbon\Carbon::parse($contract[2])->format('jS F,Y') }}
                                            </td>
                                            <td scope="row">
                                                {{ Carbon\Carbon::parse($contract[3])->format('jS F,Y') }}
                                            </td>
                                            <td scope="row">{{ number_format($contract[4], 2) }}</td>
                                            <td scope="row" class="text-danger">Employee not Existing</td>
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

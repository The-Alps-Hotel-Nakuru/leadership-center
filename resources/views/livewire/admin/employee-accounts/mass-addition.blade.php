<div>
    <x-slot:header>
        Mass Addition of Bank Accounts
    </x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Upload Accounts File</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="" class="form-label">Mass Accounts Upload</label>
                <input type="file" wire:model='accountsFile' class="form-control" name="" id=""
                    aria-describedby="helpId" placeholder="">
                @error('accountsFile')
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
        @if ($validAccounts)
            <div class="col-md-4 col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5><strong>Ready Bank Accounts <small>({{ count($validAccounts) }} Accounts)</small></strong>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-height:400px">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Bank</th>
                                        <th scope="col">Bank Short Name</th>
                                        <th scope="col">Account Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($validAccounts as $key => $account)
                                        <tr class="">
                                            <td scope="row">{{ $key + 1 }}</td>
                                            <td scope="row">{{ $account[0] }}</td>
                                            <td scope="row">{{ App\Models\User::find($account[0])->name }}</td>
                                            <td scope="row">
                                                {{ App\Models\User::find($account[0])->employee->designation->title }}
                                            <td scope="row">
                                                {{ App\Models\Bank::where('short_name', $account[1])->first()->name }}
                                            </td>
                                            <td scope="row">
                                                {{ App\Models\Bank::where('short_name', $account[1])->first()->short_name }}
                                            </td>
                                            <td scope="row">
                                                {{ $account[2] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-2">
                            <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="uploadAccounts"
                                wire:click="uploadAccounts">
                                <span wire:loading.remove wire:target="uploadAccounts">
                                    Upload Users
                                </span>
                                <span wire:loading wire:target="uploadAccounts">
                                    Uploading...
                                </span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        @endif
        @if ($alreadyExisting)
            <div class="col-md-4 col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5><strong>Already Existing Accounts <small>({{ count($alreadyExisting) }} Accounts
                                )</small></strong></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-height:400px">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Bank Short Name</th>
                                        <th scope="col">Account Number</th>
                                        <th scope="col">Existing Account</th>
                                        <th scope="col">Account Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alreadyExisting as $account)
                                        <tr class="">
                                            <td scope="row">{{ $account[0][0] }}</td>
                                            <td scope="row">{{ $account[0][1] }}</td>
                                            <td scope="row">{{ $account[0][2] }}</td>
                                            <td scope="row">{{ $account[1]->bank->name }}</td>
                                            <td scope="row">{{ $account[1]->account_number }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        @endif
        @if ($invalidAccounts)
            <div class="col-md-4 col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5><strong>Invalid Accounts <small>({{ count($invalidAccounts) }} Accounts)</small></strong>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-height:400px">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Bank Short Name</th>
                                        <th scope="col">Account Number</th>
                                        <th scope="col">Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invalidAccounts as $account)
                                        <tr class="">
                                            <td scope="row">{{ $account[0] }}</td>
                                            <td scope="row">{{ $account[1] }}</td>
                                            <td scope="row">{{ $account[2] }}</td>
                                            <td scope="row" class="text-danger">Employee Not Found</td>
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

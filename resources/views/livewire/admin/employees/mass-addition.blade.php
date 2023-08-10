<div>
    <x-slot:header>
        Mass Addition of Employees
        </x-slot>

        <div class="card">
            <div class="card-header">
                <h5>Upload Employee Data</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="" class="form-label">File Upload</label>
                    <input type="file" name="employeeFile" id="" class="form-control" wire:model='employeeFile'>
                    @error('employeeFile')
                        <small id="helpId" class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- <button class="btn btn-primary" wire:click='checkData'>Check Data</button> --}}
                <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="checkData"
                    wire:click="checkData">
                    <span wire:loading.remove wire:target="checkData">
                        Check Data
                    </span>
                    <span wire:loading wire:target="checkData">
                        Checking...
                    </span>
                </button>
            </div>
        </div>

        <div class="row mt-3">
            @if ($readyUsers)

                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Ready to Create</h5>
                        </div>
                        <div class="table-responsive">
                            <table
                                class="table table-striped
                            table-hover
                            table-borderless

                            align-middle">
                                <thead class="">
                                    <caption></caption>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>National ID</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @foreach ($readyUsers as $readyUser)
                                        @php
                                            $nameArray = explode(' ', $readyUser[3]);
                                        @endphp
                                        <tr class="">
                                            <td scope="row">{{ $nameArray[0] }}</td>
                                            <td scope="row">{{ $nameArray[1] }}</td>
                                            <td>{{ $readyUser[4] }}</td>
                                            <td>{{ $readyUser[2] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                        <div class="row mb-2">
                            <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="uploadUsers"
                                wire:click="uploadUsers">
                                <span wire:loading.remove wire:target="uploadUsers">
                                    Upload Users
                                </span>
                                <span wire:loading wire:target="uploadUsers">
                                    Uploading...
                                </span>
                            </button>
                        </div>

                    </div>
                </div>
            @endif
            @if ($existingUsers)
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Already Created</h5>
                        </div>
                        <div class="table-responsive">
                            <table
                                class="table table-striped
                            table-hover
                            table-borderless

                            align-middle">
                                <thead class="">
                                    <caption></caption>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>National ID</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @foreach ($existingUsers as $existingUser)
                                        @php
                                            $nameArray = explode(' ', $existingUser[3]);
                                        @endphp
                                        <tr class="">
                                            <td scope="row">{{ $nameArray[0] }}</td>
                                            <td scope="row">{{ $nameArray[count($nameArray) - 1] }}</td>
                                            <td>{{ $existingUser[4] }}</td>
                                            <td>{{ $existingUser[2] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            @if ($invalidUsers)
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Invalid Data</h5>
                        </div>
                        <div class="table-responsive">
                            <table
                                class="table table-striped
                            table-hover
                            table-borderless

                            align-middle">
                                <thead class="">
                                    <caption></caption>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>National ID</th>
                                        <th>Reasons For Invalidity</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @foreach ($invalidUsers as $invalidUser)
                                        @php
                                            $nameArray = explode(' ', $invalidUser[3]);
                                        @endphp
                                        <tr class="">
                                            <td scope="row">{{ $nameArray[0] }}</td>
                                            <td scope="row">{{ $nameArray[count($nameArray) - 1] }}</td>
                                            <td>{{ $invalidUser[4] }}</td>
                                            <td>{{ $invalidUser[2] }}</td>
                                            @php
                                                $reason = 'Missing Mandatory Field: ';
                                                foreach ($invalidUser as $key => $value) {
                                                    if (!$value) {
                                                        $reason .= $key == 2 ? 'National ID, ' : ($key == 3 ? 'Name, ' : ($key == 4 ? 'Email Address, ' : ($key == 5 ? 'Gender, ' : ($key == 6 ? 'Designation, ' : ($key == 7 ? 'Phone Number (Invalid Format or Null), ' : ($key == 8 ? 'Birthday, ' : ($key == 10 ? 'Nationality, ' : ($key == 11 ? 'KRA Pin, ' : ''))))))));
                                                    }
                                                }
                                                
                                                if (!preg_match('/^\d{10}$/', $invalidUser[7])) {
                                                    $reason .= ' + Invalid phone number format';
                                                }
                                                if (!App\Models\Designation::where('title', 'LIKE', '%' . $invalidUser[6] . '%')->exists()) {
                                                    $reason .= ' + Designation Has not been written correctly or doesn\'t exist';
                                                }
                                            @endphp
                                            <td class="text-danger">{{ $reason }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
</div>

</div>
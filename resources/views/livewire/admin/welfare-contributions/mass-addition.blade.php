<div>
    <x-slot:header>
        Mass Addition of Welfare Contributions
    </x-slot:header>

    <div class="card" style="max-height: 500px">
        <div class="card-header">
            <h5>Upload Welfare Contribution File</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="" class="form-label">Mass Welfare Contributions Upload</label>
                <input type="file" wire:model='welfarecontributionFile' class="form-control" name=""
                    id="" aria-describedby="helpId" placeholder="">
                @error('welfarecontributionFile')
                    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Month and Year</label>
                <input type="month" wire:model='yearmonth' class="form-control" name="" id=""
                    aria-describedby="helpId" placeholder="">
                @error('yearmonth')
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
        @if ($validWelfareContributions)
            <div class="col-md-4 col-12 mb-3">
                <div class="card" style="max-height: 500px">
                    <div class="card-header">
                        <h5><strong>Welfare Contributions to Be Uploaded</strong></h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th scope="col">Employee Name</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">Effected Month</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($validWelfareContributions as $welfarecontribution)
                                    <tr class="">
                                        <td scope="row">
                                            {{ App\Models\EmployeesDetail::where('national_id', $welfarecontribution[0])->first()->user->name }}
                                        </td>
                                        <td scope="row">
                                            KES {{ number_format($welfarecontribution[2]) }}
                                        </td>
                                        <td scope="row">
                                            {{ $welfarecontribution[3] }}
                                        </td>
                                        <td scope="row">
                                            {{ Carbon\Carbon::parse($welfarecontribution[4] . '-' . $welfarecontribution[5])->format('F, Y') }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-2">
                        <button class="btn btn-primary" wire:loading.attr="disabled"
                            wire:target="uploadWelfareContributions" wire:click="uploadWelfareContributions">
                            <span wire:loading.remove wire:target="uploadWelfareContributions">
                                Upload WelfareContributions
                            </span>
                            <span wire:loading wire:target="uploadWelfareContributions">
                                Uploading...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        @if ($alreadyExisting)
            <div class="col-md-4 col-12 mb-3">
                <div class="card" style="max-height: 500px">
                    <div class="card-header">
                        <h5><strong>Already Existing WelfareContributions</strong></h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th scope="col">User ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alreadyExisting as $welfarecontribution)
                                    <tr class="">
                                        <td scope="row">
                                            {{ App\Models\EmployeesDetail::where('national_id', $welfarecontribution[0])->first()->user->id }}
                                        </td>
                                        <td scope="row">
                                            {{ App\Models\EmployeesDetail::where('national_id', $welfarecontribution[0])->first()->user->name }}
                                        </td>
                                        <td scope="row">
                                            KES {{ number_format($welfarecontribution[2], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if ($invalidWelfareContributions)
            <div class="col-md-4 col-12 mb-3">
                <div class="card" style="max-height: 500px">
                    <div class="card-header">
                        <h5><strong>Invalid WelfareContributions</strong></h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th scope="col">User ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Invalidity Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invalidWelfareContributions as $welfarecontribution)
                                    <tr class="">
                                        <td scope="row">
                                            {{ App\Models\EmployeesDetail::where('national_id', $welfarecontribution[0][0])->first() ? App\Models\EmployeesDetail::where('national_id', $welfarecontribution[0][0])->first()->user->id : 'User ID Not found (' . $welfarecontribution[0][0] . ')' }}
                                        </td>
                                        <td scope="row">
                                            {{ App\Models\EmployeesDetail::where('national_id', $welfarecontribution[0][0])->first() ? App\Models\EmployeesDetail::where('national_id', $welfarecontribution[0][0])->first()->user->name : 'User Name not found' }}
                                        </td>
                                        <td scope="row">
                                            KES {{ number_format($welfarecontribution[2], 2) }}
                                        </td>
                                        <td scope="row">
                                            {{ $welfarecontribution[1] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

    </div>

</div>

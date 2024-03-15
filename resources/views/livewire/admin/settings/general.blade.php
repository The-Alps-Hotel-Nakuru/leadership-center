<div>
    <x-slot:header>General Settings</x-slot:header>

    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header bg-transparent border-0">
                    <h5>Company Details</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="saveCompanyDetails">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" name="" wire:model='companyName'
                                        id="" aria-describedby="helpId" placeholder="">
                                    @error('companyName')
                                        <span class="form-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Company Email</label>
                                    <input type="text" class="form-control" name="" wire:model='companyEmail'
                                        id="" aria-describedby="helpId" placeholder="">
                                    @error('companyEmail')
                                        <span class="form-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class=" col-12 mb-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Company Logo</label>
                                    <img src="/company_logo.png?{{ random_int(1, 56123) }}" alt=""
                                        class="img-fluid img-thumbnail ">
                                    <input type="file" class="form-control" name="" wire:model='companyLogo'
                                        id="" aria-describedby="helpId" placeholder="">
                                    @error('companyLogo')
                                        <span class="form-text text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                        </div>
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-transparent border-0">
                            <h5>Attendance Format</h5>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="saveAttendanceFormat">
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="attendanceDateFormat" class="form-label">Attendance Date
                                            Format:</label>
                                        @php
                                            $dateFormats = [
                                                'Y-m-d' => 'YYYY-MM-DD',
                                                'd/m/Y' => 'DD/MM/YYYY',
                                                'm-d-Y' => 'MM-DD-YYYY',
                                                'F j, Y' => 'Month D, YYYY',
                                                'l, F j, Y' => 'Day, Month D, YYYY',
                                                'l, M j, Y' => 'Day, Mon D, YYYY',
                                            ];
                                        @endphp
                                        <select class="form-control" wire:model='attendanceDateFormat'
                                            id="dateFormatsSelect">
                                            <option selected> Select your Option</option>
                                            @foreach ($dateFormats as $key => $format)
                                                <option value="{{ $key }}">{{ $format }}</option>
                                            @endforeach
                                        </select>
                                        @error('attendanceDateFormat')
                                            <span class="form-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Settings</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-transparennt border-0">
                            <h5>Main Bank Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="bankName" class="form-label">Bank Short Name</label>
                                        <input wire:model='bankName' type="text" class="form-control" name="bankName"
                                            id="bankName" aria-describedby="helpId"
                                            placeholder="Enter your Account Number">
                                        <small id="helpId" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="sortCode" class="form-label">Bank Sort Code</label>
                                        <input wire:model='sortCode' type="text" class="form-control" name="sortCode"
                                            id="sortCode" aria-describedby="helpId"
                                            placeholder="Enter your Account Number">
                                        <small id="helpId" class="form-text text-muted"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="account_number" class="form-label">Account Number</label>
                                <input wire:model='accountNumber' type="text" class="form-control"
                                    name="account_number" id="account_number" aria-describedby="helpId"
                                    placeholder="Enter your Account Number">
                                <small id="helpId" class="form-text text-muted"></small>
                            </div>
                            <button class="btn btn-primary" wire:click='saveAccountDetails'>Save Account
                                Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

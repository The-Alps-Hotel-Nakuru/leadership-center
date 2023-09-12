<div>
    <x-slot:header>My Profile</x-slot:header>

    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0 shadow">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2" style="height:200px"
                        src="{{ auth()->user()->profile_photo_url }}" alt="">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    <!-- Profile picture upload button-->
                    <button class="btn btn-primary" onclick="$('#profilePhotoInput').click()" type="button">Upload
                        new image</button>
                    <input type="file" hidden id="profilePhotoInput" wire:model="profilePhoto" x-ref="profilePhoto">
                    {{-- @if ($profilePhoto->preview) --}}
                    <div class="mt-2" x-show="! photoPreview">
                        {{-- <img src="{{ $this->user->profile_photo_url }}" class="rounded-circle" height="80px"
                                width="80px"> --}}
                    </div>
                    {{-- @endif --}}
                </div>
            </div>
            <div class="mt-4"></div>
            <div class="card mb-4 mb-xl-0 shadow">
                <div class="card-header">Payment Account Details</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="bank_id" class="form-label">Bank</label>
                        <select wire:model="account.bank_id" class="form-select form-select-lg" name="bank_id"
                            id="bank_id">
                            <option selected>Select one</option>
                            @foreach (App\Models\Bank::all() as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                        @error('account.bank_id')
                            <small id="account_number" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="account_number" class="form-label">Account Number</label>
                        <input wire:model='account.account_number' type="text" class="form-control"
                            name="account_number" id="account_number" aria-describedby="account_number"
                            placeholder="Enter your Account Number">
                        @error('account.account_number')
                            <small id="account_number" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4 shadow">
                <div class="card-header">
                    <h5 class="text-uppercase">Basic Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="small mb-1" for="inputUsername">First Name(s) </label>
                            <input wire:model='user.first_name' class="form-control" id="inputUsername" type="text"
                                placeholder="Enter your First Name">
                            @error('user.first_name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1" for="inputUsername">Surname </label>
                            <input wire:model='user.last_name' class="form-control" id="inputUsername" type="text"
                                placeholder="Enter your Last Name">
                            @error('user.last_name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="small mb-1" for="inputOrgName">Email Address</label>
                            <input class="form-control" wire:model='user.email' id="inputOrgName" type="email"
                                placeholder="Enter your Email Address">
                            @error('user.email')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Gender </label>
                                <select wire:model='employee.gender' class="form-select form-select-lg" name=""
                                    id="">
                                    <option selected>Select one</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            @error('employee.gender')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- Form Group (location)-->
                        <div class="col-md-6">
                            <label class="small mb-1" for="birth_date">Date of Birth</label>
                            <input class="form-control" wire:model='employee.birth_date' id="birth_date" type="date"
                                placeholder="Enter your Phone Number">
                            @error('employee.birth_date')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1" for="national_id">National ID Number</label>
                            <input class="form-control" wire:model='employee.national_id' id="national_id"
                                type="number" placeholder="Enter your Phone Number">
                            @error('employee.national_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1" for="phone_number">Phone Number</label>
                            <input class="form-control" wire:model='employee.phone_number' id="phone_number"
                                type="text" placeholder="Enter your Phone Number">
                            @error('employee.phone_number')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveBasicDetails"
                        wire:click="saveBasicDetails">
                        <span wire:loading.remove wire:target="saveBasicDetails">
                            Save Details
                        </span>
                        <span wire:loading wire:target="saveBasicDetails">
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
            <div class="card mb-4 shadow">
                <div class="card-header">
                    <h5 class="text-uppercase">More Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">KRA PIN</label>
                                <input type="text" wire:model='employee.kra_pin' class="form-control"
                                    name="" id="" aria-describedby="helpId"
                                    placeholder="Enter Your KRA PIN">
                                @error('employee.kra_pin')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">NSSF PIN</label>
                                <input type="text" wire:model='employee.nssf' class="form-control" name=""
                                    id="" aria-describedby="helpId" placeholder="Enter Your NSSF PIN">
                                @error('employee.nssf')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">NHIF PIN</label>
                                <input type="text" wire:model='employee.nhif' class="form-control" name=""
                                    id="" aria-describedby="helpId" placeholder="Enter Your NHIF PIN">
                                @error('employee.nhif')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror

                            </div>
                        </div>

                    </div>
                    <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveMoreDetails"
                        wire:click="saveMoreDetails">
                        <span wire:loading.remove wire:target="saveMoreDetails">
                            Save Details
                        </span>
                        <span wire:loading wire:target="saveMoreDetails">
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

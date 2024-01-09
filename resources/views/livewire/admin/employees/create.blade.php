<div>
    <x-slot name="header">Employees' Details</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-transparent border-0">
                <h5>Create a new Employee</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 text-end text-uppercase">
                        <h6>Basic Details</h6>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">
                                First Name
                                <span class="text-danger">*</span>
                            </label>
                            <input wire:model="employee.first_name" type="text" class="form-control"
                                name="first_name" id="first_name" aria-describedby="first_name"
                                placeholder="Enter the First Name">
                            @error('employee.first_name')
                                <small id="first_name" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span>
                            </label>
                            <input wire:model="employee.last_name" type="text" class="form-control" name="last_name"
                                id="last_name" aria-describedby="last_name" placeholder="Enter the Last Name">
                            @error('employee.last_name')
                                <small id="last_name" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address<span
                                    class="text-danger">*</span></label>
                            <input wire:model="employee.email" type="email" class="form-control" name="email"
                                id="email" aria-describedby="email" placeholder="Enter the Email Address">
                            @error('employee.email')
                                <small id="email" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number<span
                                    class="text-danger">*</span></label>
                            <input wire:model="detail.phone_number" type="text" class="form-control"
                                name="phone_number" aria-describedby="phone_number"
                                placeholder="Enter the Phone Number">
                            @error('detail.phone_number')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="national_id" class="form-label">National ID<span
                                    class="text-danger">*</span></label>
                            <input wire:model="detail.national_id" type="number" class="form-control"
                                name="national_id" aria-describedby="national_id" placeholder="Enter the Phone Number">
                            @error('detail.national_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control " name="photo" wire:model="photo"
                                id="photo">
                            @error('photo')
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        @if ($photo)
                            Photo Preview:
                            <img class="img-thumbnail" width="150px" src="{{ $photo->temporaryUrl() }}">
                        @endif
                    </div>


                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-12 text-end">
                        <h6>OTHER DETAILS</h6>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="dpt_id" class="form-label">Department<span
                                    class="text-danger">*</span></label>
                            <select wire:model="dpt_id" class="form-control" name="dpt_id" id="dpt_id">
                                <option @if ($dpt_id) selected disabled @endif>Select the Department
                                </option>
                                @foreach (App\Models\Department::all() as $dpt)
                                    <option value="{{ $dpt->id }}">{{ $dpt->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="dpt_id" class="form-label">Designation<span
                                    class="text-danger">*</span></label>
                            <select wire:model="detail.designation_id" class="form-control" name="dpt_id"
                                id="dpt_id">
                                <option selected>Select the Designation</option>
                                @foreach (App\Models\Designation::all() as $designation)
                                    @if ($designation->department_id == $dpt_id)
                                        <option value="{{ $designation->id }}">{{ $designation->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('detail.designation_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="mb-3">
                            <label for="marital_status" class="form-label">Marital Status<span
                                    class="text-danger">*</span></label>
                            <select wire:model="detail.marital_status" class="form-control" name="marital_status"
                                id="marital_status">
                                <option>Select your Marital Status</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="divorced">Divorced</option>
                                <option value="widowed">Widowed</option>
                            </select>
                            @error('detail.marital_status')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="mb-3">
                            <label for="birth_date" class="form-label">Birth Date<span
                                    class="text-danger">*</span></label>
                            <input wire:model="detail.birth_date" type="date" class="form-control"
                                name="birth_date" id="birth_date" aria-describedby="helpId"
                                placeholder="Enter your Date of Birth">
                            @error('detail.birth_date')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                            <select wire:model="detail.gender" class="form-control" name="gender" id="gender">
                                <option>Select a Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            @error('detail.gender')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="physical_address" class="form-label">Physical Address</label>
                            <textarea wire:model="detail.physical_address" placeholder="Enter your Physical Address" class="form-control"
                                name="physical_address" id="physical_address" rows="2"></textarea>

                            @error('detail.physical_address')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="mb-3">
                            <label for="kra_pin" class="form-label">KRA PIN<span
                                    class="text-danger">*</span></label>
                            <input wire:model="detail.kra_pin" type="text" class="form-control" name="kra_pin"
                                id="kra_pin" aria-describedby="kra_pin" placeholder="Enter your KRA PIN">
                            @error('detail.kra_pin')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="mb-3">
                            <label for="nssf" class="form-label">NSSF Identifier</label>
                            <input wire:model="detail.nssf" type="text" class="form-control" name="nssf"
                                id="nssf" aria-describedby="nssf" placeholder="Enter your NSSF Identifier">
                            @error('detail.nssf')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="mb-3">
                            <label for="nhif" class="form-label">NHIF Identifier</label>
                            <input wire:model="detail.nhif" type="text" class="form-control" name="nhif"
                                id="nhif" aria-describedby="nhif" placeholder="Enter your NHIF Identifier">
                            @error('detail.nhif')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="handicap" class="form-label">Handicap Description</label>
                            <textarea wire:model="detail.handicap" placeholder="Enter the Description of Your Handicap" class="form-control"
                                name="handicap" id="handicap" rows="2"></textarea>
                            @error('detail.handicap')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-12 text-end">
                        <h5>File Upload (Optional)</h5>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="mb-3">
                            <label for="kra_file" class="form-label">KRA PIN File</label>
                            <input wire:model="kra_file" type="file" class="form-control" name="kra_file"
                                id="kra_file" aria-describedby="kra_file" placeholder="Upload Your KRA Pin">
                            @error('kra_file')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="mb-3">
                            <label for="nssf_file" class="form-label">NSSF PIN File</label>
                            <input wire:model="nssf_file" type="file" class="form-control" name="nssf_file"
                                id="nssf_file" aria-describedby="nssf_file" placeholder="Upload Your NSSF Pin">
                            @error('nssf_file')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="mb-3">
                            <label for="nhif_file" class="form-label">NHIF PIN File</label>
                            <input wire:model="nhif_file" type="file" class="form-control" name="nhif_file"
                                id="nhif_file" aria-describedby="nhif_file" placeholder="Upload Your NHIF Pin">
                            @error('nhif_file')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="mb-3">
                            <label for="bank_id" class="form-label">Bank <span class="text-danger">*</span></label>
                            <select wire:model="account.bank_id" class="form-control" name="bank_id"
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
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="mb-3">
                            <label for="account_number" class="form-label">Account Number <span class="text-danger">*</span></label>
                            <input wire:model='account.account_number' type="text" class="form-control"
                                name="account_number" id="account_number" aria-describedby="account_number"
                                placeholder="Enter your Account Number">
                            @error('account.account_number')
                                <small id="account_number" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="save" wire:click="save">
                    <span wire:loading.remove wire:target="save">
                        Save
                    </span>
                    <span wire:loading wire:target="save">
                        Saving...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

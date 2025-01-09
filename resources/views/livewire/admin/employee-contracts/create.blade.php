<div>
    <x-slot name="header">
        Employee's Contracts
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>
                    Create a New Contract
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="employees_detail_id" class="form-label">Employee</label>
                            <select wire:model.live="contract.employees_detail_id" class="form-control"
                                name="employees_detail_id" id="employees_detail_id">
                                <option>Select Which Employee to Give a Contract</option>
                                @foreach (App\Models\EmployeesDetail::all() as $employee)
                                    <option @if ($employee->has_active_contract) disabled @endif
                                        value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                @endforeach
                            </select>
                            @error('contract.employees_detail_id')
                                <small id="employees_detail_id" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="designation_id" class="form-label">Designation</label>
                            <select wire:model.live="contract.designation_id" class="form-control" name="designation_id"
                                id="designation_id">
                                <option>Select The Designation</option>
                                @foreach (App\Models\Designation::all() as $designation)
                                    <option value="{{ $designation->id }}">{{ $designation->title }}</option>
                                @endforeach
                            </select>
                            @error('contract.designation_id')
                                <small id="designation_id" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="employment_type_id" class="form-label">Employment Type</label>
                            <select wire:model.live="contract.employment_type_id" class="form-control"
                                name="employment_type_id" id="employment_type_id">
                                <option>Choose how their Employment will Be</option>
                                @foreach (App\Models\EmploymentType::all() as $type)
                                    <option value="{{ $type->id }}">{{ $type->title }}</option>
                                @endforeach
                            </select>
                            @error('contract.employment_type_id')
                                <small id="employment_type_id" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="is_taxable" class="form-label">Taxable</label>
                            <select wire:model.live="contract.is_taxable" class="form-control" name="is_taxable"
                                id="is_taxable">
                                <option value="1" selected>True</option>
                                <option value="0">False</option>
                            </select>
                            @error('contract.is_taxable')
                                <small id="is_taxable" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="weekly_offs" class="form-label">Weekly Offs</label>
                            <input wire:model.live="contract.weekly_offs" type="number" class="form-control"
                                name="weekly_offs" id="weekly_offs" aria-describedby="weekly_offs"
                                placeholder="Enter the Appointment Date">
                            @error('contract.weekly_offs')
                                <small id="weekly_offs" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Appointment Date</label>
                            <input wire:model.live="contract.start_date" type="date" class="form-control"
                                name="start_date" id="start_date" aria-describedby="start_date"
                                placeholder="Enter the Appointment Date">
                            @error('contract.start_date')
                                <small id="start_date" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Expiry Date</label>
                            <input wire:model.live="contract.end_date" type="date" class="form-control" name="end_date"
                                id="end_date" aria-describedby="end_date" placeholder="Enter the Appointment Date">
                            @error('contract.end_date')
                                <small id="end_date" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        {{-- <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="months" class="form-label">Duration</label>
                            <select wire:model.live="months" class="form-select form-select-sm" name="months" id="months">
                                <option selected>Select Duration</option>
                                <option value="6">6 Months</option>
                                <option value="12">1 year</option>
                                <option value="36">3 years</option>
                            </select>
                            @error('months')
                                <small id="end_date" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div> --}}
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="mb-3">
                            <label for="salary_kes" class="form-label">Salary <small
                                    class="text-muted text-capitalize">({{ $contract->employment_type->rate_type ?? 'per employment terms' }})</small></label>
                            <input wire:model.live="contract.salary_kes" type="number" class="form-control"
                                name="salary_kes" id="salary_kes" aria-describedby="salary_kes"
                                placeholder="Enter your Salary">
                            @error('contract.salary_kes')
                                <small id="end_date" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <label for="">Treat Salary As</label>
                            <select class="form-control" name="" id="" wire:model.live="contract.is_net">
                                <option selected> Please Select how you would want this Salary to be</option>
                                <option value="0">Gross Salary</option>
                                <option value="1">Net Salary
                                </option>
                            </select>
                            @error('contract.is_net')
                                <small id="end_date" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-dark text-uppercase" wire:click="save">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<div>
    <x-slot:header>Leave Types</x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Create a new Leave type</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="" class="form-label">Title</label>
                        <input type="text" class="form-control" name="" id="" aria-describedby="title"
                            placeholder="Enter your Title" wire:model.live='leaveType.title' />
                        @error('leaveType.title')
                            <small id="title" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="" class="form-label">Description</label>
                        <input type="text" class="form-control" name="" id=""
                            aria-describedby="description" placeholder="Enter your Description"
                            wire:model.live='leaveType.description' />
                        @error('leaveType.description')
                            <small id="description" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="mb-3">
                        <label for="" class="form-label">Max Days</label>
                        <input type="number" class="form-control" name="" id=""
                            aria-describedby="max_days" placeholder="Enter your Max Days"
                            wire:model.live='leaveType.max_days' />
                        @error('leaveType.max_days')
                            <small id="max_days" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="mb-3">
                        <label for="" class="form-label">Full Pay Days</label>
                        <input type="number" class="form-control" name="" id=""
                            aria-describedby="full_pay_days" placeholder="Enter your Full Pay Days"
                            wire:model.live='leaveType.full_pay_days' />
                        @error('leaveType.full_pay_days')
                            <small id="full_pay_days" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="mb-3">
                        <label for="" class="form-label">Half Pay Days</label>
                        <input type="number" class="form-control" name="" id=""
                            aria-describedby="half_pay_days" placeholder="Enter your Half Pay Days"
                            wire:model.live='leaveType.half_pay_days' />
                        @error('leaveType.half_pay_days')
                            <small id="half_pay_days" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="mb-3">
                        <label for="" class="form-label">Monthly Accrual Rate</label>
                        <input type="number" class="form-control" name="" id=""
                            aria-describedby="monthly_accrual_rate" placeholder="Enter your Monthly Accrual Rate"
                            wire:model.live='leaveType.monthly_accrual_rate' />
                        @error('leaveType.monthly_accrual_rate')
                            <small id="monthly_accrual_rate" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Minimum Months Worked --}}
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="" class="form-label">Minimum Months Required</label>
                        <input type="text" class="form-control" name="" id=""
                            aria-describedby="min_months_worked" placeholder="Enter your Minimum Months Required"
                            wire:model.live='leaveType.min_months_worked' />
                        @error('leaveType.min_months_worked')
                            <small id="min_months_worked" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                {{-- Is a Paid Leave && Can Accumulate Days --}}
                <div class="col-md-6 col-12">
                    <div class="d-flex h-100 align-items-center">
                        <div class="m-auto">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"
                                    wire:model.live='leaveType.is_paid' />
                                <label class="form-check-label" for="flexSwitchCheckDefault">Is a paid leave
                                    type?</label>
                            </div>
                        </div>
                        <div class="m-auto">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"
                                    wire:model.live='leaveType.can_accumulate' />
                                <label class="form-check-label" for="flexSwitchCheckDefault">Can Accumulate?</label>
                            </div>
                        </div>
                        <div class="m-auto">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault"
                                    wire:model.live='leaveType.is_gender_specific' />
                                <label class="form-check-label" for="flexSwitchCheckDefault">Is Gender
                                    Specific?</label>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($leaveType->can_accumulate)
                <div class="col-md-4 col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Carry Forward Limit</label>
                        <input type="number" class="form-control" name="" id=""
                            aria-describedby="carry_forward_limit" placeholder="Enter your Half Pay Days"
                            wire:model.live='leaveType.carry_forward_limit' />
                        @error('leaveType.carry_forward_limit')
                            <small id="carry_forward_limit" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                @endif
                @if ($leaveType->is_gender_specific)
                    <div class="col-md-4 col-6">
                        <div class="d-flex h-100">
                            <div class="form-check form-check-inline m-auto">
                                <input class="form-check-input" type="radio" wire:model.live='leaveType.gender'
                                    name="inlineRadioOptions" id="inlineRadio1" value="male">
                                <label class="form-check-label" for="inlineRadio1">Male</label>
                            </div>
                            <div class="form-check form-check-inline m-auto">
                                <input class="form-check-input" type="radio" wire:model.live='leaveType.gender'
                                    name="inlineRadioOptions" id="inlineRadio2" value="female">
                                <label class="form-check-label" for="inlineRadio2">Female</label>
                            </div>
                        </div>

                        @error('leaveType.gender')
                            <small id="gender" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                @endif
            </div>
            <button class="btn btn-dark" wire:click='save'>
                SAVE
            </button>
        </div>
    </div>
</div>

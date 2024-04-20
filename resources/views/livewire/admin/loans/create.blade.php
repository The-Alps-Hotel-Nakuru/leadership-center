<div>
    <x-slot:header>
        Loans
    </x-slot:header>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Create a Loan Record</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    {{-- Selected Employee --}}
                    <div class="col-12">
                        <label for="month">Search an Employee</label>
                        <input type="text" class="form-control" wire:model="search" placeholder="Search employees">
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <ul class="list-group mt-2 w-100">
                                @if ($search != '')
                                    @foreach ($employees as $employee)
                                        @if (
                                            $employee->isFullTimeBetween(
                                                $leave->start_date ?? Carbon\Carbon::now()->toDateString(),
                                                $leave->end_date ?? Carbon\Carbon::now()->toDateString()) ||
                                                $employee->isExternalBetween(
                                                    $leave->start_date ?? Carbon\Carbon::now()->toDateString(),
                                                    $leave->end_date ?? Carbon\Carbon::now()->toDateString()))
                                            <li wire:click="selectEmployee({{ $employee->id }})"
                                                class="list-group-item {{ $selectedEmployee == $employee->id ? 'active' : '' }}">
                                                {{ $employee->user->name }}
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                            @error('selectedEmployee')
                                <small id="time" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Loan Amount --}}

                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <label for="amount">Amount (KES)</label>
                            <input type="number" wire:model='loan.amount' class="form-control" name="amount"
                                id="amount" aria-describedby="amount" placeholder="Enter the loan amount">
                            @error('loan.amount')
                                <small id="amount" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    {{-- First Payment Month --}}
                    <div class="col-md-4 col-6">
                        <div class="form-group">
                            <label for="month">First Repayment Month</label>
                            <input type="month" wire:model='yearmonth' class="form-control" name="month"
                                id="month" aria-describedby="month"
                                placeholder="Enter the First Month of Repayment">
                            @error('yearmonth')
                                <small id="amount" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Number of Repayment Months --}}
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="repaymentmonths">Number of Months to Repay</label>
                            <input type="number" wire:model='repaymentmonths' class="form-control"
                                name="repaymentmonths" id="repaymentmonths" aria-describedby="repaymentmonths"
                                placeholder="Enter the number of Repayment Months">
                            @error('repaymentmonths')
                                <small id="repaymentmonths" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    {{-- Transaction Code --}}
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="transaction">Transaction Code</label>
                            <input type="text" wire:model='loan.transaction' class="form-control" name="transaction"
                                id="transaction" aria-describedby="transaction"
                                placeholder="Enter the Transaction Reference Code">
                            @error('loan.transaction')
                                <small id="transaction" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Reason For Loan --}}
                    <div class="col-12">
                        <div class="form-group">
                            <label for="reason">Reason for Loan</label>
                            <textarea class="form-control" wire:model='loan.reason' name="reason" id="reason" rows="3"></textarea>
                            @error('loan.reason')
                                <small id="transaction" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <button class="btn btn-dark text-uppercase" wire:click='save'>Save</button>

                </div>
            </div>
        </div>
    </div>
</div>

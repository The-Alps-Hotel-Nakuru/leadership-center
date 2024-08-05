<div>
    <x-slot:header>Loan no. {{ $loan->id }} for {{ $loan->employee->user->name }}</x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>Deduction of {{ Carbon\Carbon::parse($loanDeduction->year.'-'.$loanDeduction->month)->format('F, Y') }}</h5>
        </div>
        <div class="card-body">
            <div class="form-group">
              <label for="">Amount</label>
              <input wire:model='loanDeduction.amount' type="number"
                class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
              @error('loanDeduction.amount')
                  <small id="helpId" class="form-text text-danger">{{ $message }}</small>
              @enderror
            </div>
            <button wire:click='save' class="btn btn-dark text-uppercase">Save</button>
        </div>
    </div>
</div>

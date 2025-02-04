<div>
    <x-slot:header>Loan Deduction</x-slot:header>
    <div class="card">
        <div class="card-header">
            <h5>Create a new Deduction</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" class="form-control" wire:model="deduction.amount" required>
                </div>
                <div class="form-group">
                    <label for="yearmonth">Month</label>
                    <input type="month" class="form-control" wire:model="yearmonth" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2 float-end">Create</button>
            </form>
        </div>
    </div>
</div>

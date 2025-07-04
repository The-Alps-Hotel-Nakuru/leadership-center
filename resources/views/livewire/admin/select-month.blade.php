<div>
    <div class="card shadow-sm" style="background-color: #f8f9fa; opacity: 0.95;">
        <div class="card-body">
            <form wire:submit.prevent="changeYearmonth">
                <div class="form-group mb-3">
                    <label for="yearmonth">Select Month</label>
                    <input
                        type="month"
                        class="form-control"
                        id="yearmonth"
                        wire:model="yearmonth">
                    @error('yearmonth') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

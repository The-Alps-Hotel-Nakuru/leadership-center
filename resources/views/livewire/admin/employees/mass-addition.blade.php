<div>
    <x-slot:header>
        Mass Addition of Employees
        </x-slot>

        <div class="card">
            <div class="card-header">
                <h5>Upload Employee Data</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="" class="form-label">File Upload</label>
                    <input type="file" name="employeeFile" id="" class="form-control" wire:model='employeeFile'>
                    @error('employeeFile')
                        <small id="helpId" class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button class="btn btn-primary" wire:click='checkData'>Check Data</button>
            </div>
        </div>

</div>

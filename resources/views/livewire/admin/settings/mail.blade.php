<div>
    <x-slot:header>Mail Settings</x-slot:header>

    <div class="card">
        <div class="card-header">
            Mail Settings
        </div>
        <div class="card-body">
            <form wire:submit.prevent="saveSettings">
                <div class="row">
                    <div class="col-md-6 col-12 mb-3">
                        <label for="mailUsername" class="form-label">Mail Username:</label>
                        <input type="text" class="form-control" wire:model="mailUsername">
                        @error('mailUsername')
                            <span class="form-text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="mailPassword" class="form-label">Mail Password:</label>
                        <input type="password" class="form-control" wire:model="mailPassword">
                        @error('mailPassword')
                            <span class="form-text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="mailDriver" class="form-label">Mail Driver:</label>
                        <input type="text" class="form-control" wire:model="mailDriver">
                        @error('mailDriver')
                            <span class="form-text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="mailHost" class="form-label">Mail Host:</label>
                        <input type="text" class="form-control" wire:model="mailHost">
                        @error('mailHost')
                            <span class="form-text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="mailPort" class="form-label">Mail Port:</label>
                        <input type="number" class="form-control" wire:model="mailPort">
                        @error('mailPort')
                            <span class="form-text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <label for="mailFromAddress" class="form-label">"Mail From" Address:</label>
                        <input type="text" class="form-control" wire:model="mailFromAddress">
                        @error('mailFromAddress')
                            <span class="form-text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>

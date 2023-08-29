<div>
    <x-slot:header>General Settings</x-slot:header>

    <div class="card">
        <div class="card-header">
            General Settings
        </div>
        <div class="card-body">
            <form wire:submit.prevent="saveSettings">
                <div class="row">
                    <div class="col-md-6 col-12 mb-3">
                        <label for="attendanceDateFormat" class="form-label">Attendance Date Format:</label>
                        @php
                            $dateFormats = [
                                'Y-m-d' => 'YYYY-MM-DD',
                                'd/m/Y' => 'DD/MM/YYYY',
                                'm-d-Y' => 'MM-DD-YYYY',
                                'F j, Y' => 'Month D, YYYY',
                                'l, F j, Y' => 'Day, Month D, YYYY',
                                'l, M j, Y' => 'Day, Mon D, YYYY',
                            ];
                        @endphp
                        <select class="form-control" wire:model='attendanceDateFormat' id="dateFormatsSelect">
                            <option selected> Select your Option</option>
                            @foreach ($dateFormats as $key => $format)
                                <option value="{{ $key }}">{{ $format }}</option>
                            @endforeach
                        </select>
                        @error('attendanceDateFormat')
                            <span class="form-text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <div class="col-md-6 col-12 mb-3">
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
                    </div> --}}
                </div>
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>
</div>

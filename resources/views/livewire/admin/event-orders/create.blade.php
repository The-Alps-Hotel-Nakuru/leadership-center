<div>
    <x-slot name="header">
        <h4>
            Create Event Order
        </h4>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h5>Create a new Event Order</h5>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="organization_name" class="form-label">Organization Name <span
                                class="text-danger"><b>*</b></span></label>
                        <input wire:model='event_order.organization_name' type="text" class="form-control"
                            name="organization_name" id="organization_name" aria-describedby="organization_name"
                            placeholder="Enter the Name of the Organization">
                        @error('event_order.organization_name')
                            <small id="organization_name" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="event_name" class="form-label">Event Name</label>
                        <input wire:model='event_order.event_name' type="text" class="form-control" name="event_name"
                            id="event_name" aria-describedby="event_name" placeholder="Enter the name of the event">
                        @error('event_order.event_name')
                            <small id="event_name" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="contact_name" class="form-label">Contact Name <span
                                class="text-danger"><b>*</b></span></label>
                        <input wire:model='event_order.contact_name' type="text" class="form-control"
                            name="contact_name" id="contact_name" aria-describedby="contact_name"
                            placeholder="Enter the Name of the contact">
                        @error('event_order.contact_name')
                            <small id="contact_name" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="conference_hall_id" class="form-label">Conference Hall <span
                                class="text-danger"><b>*</b></span></label>
                        <select multiple wire:model="conference_halls" class="form-select" name="conference_hall_id" id="conference_hall_id">
                            <option disabled selected>Select a Conference Hall</option>
                            @foreach (App\Models\ConferenceHall::all() as $hall)
                                <option value="{{ $hall->id }}">{{ $hall->name }}</option>
                            @endforeach
                        </select>
                        @error('event_order.conference_hall_id')
                            <small id="contact_name" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date <span
                            class="text-danger"><b>*</b></span></label>
                        <input wire:model="event_order.start_date" type="date" class="form-control" name="start_date"
                            id="start_date" aria-describedby="start_date" placeholder="Enter the Starting Date">
                        @error('event_order.start_date')
                            <small id="start_date" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date <span
                            class="text-danger"><b>*</b></span></label>
                        <input wire:model="event_order.end_date" type="date" class="form-control" name="end_date"
                            id="end_date" aria-describedby="end_date" placeholder="Enter the Ending Date">
                        @error('event_order.end_date')
                            <small id="end_date" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="mb-3">
                        <label for="event_order.pax" class="form-label">Person(s) <span
                            class="text-danger"><b>*</b></span></label>
                        <input wire:model="event_order.pax" type="number" class="form-control" name="event_order.pax"
                            id="event_order.pax" aria-describedby="pax" placeholder="Enter the Pax Expected">
                        @error('event_order.pax')
                            <small id="pax" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="mb-3">
                        <label for="package" class="form-label">Package</label>
                        <select wire:model="package_id" wire:change="changedPackage" class="form-select"
                            name="package" id="package">
                            <option selected disabled>Select One Package</option>
                            @foreach ($packages as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-8">
                    <div class="mb-3">
                        <label for="event_order.rate_kes" class="form-label">Rate (KES) <span
                            class="text-danger"><b>*</b></span></label>
                        <input wire:model="event_order.rate_kes" type="number" class="form-control"
                            name="event_order.rate_kes" id="event_order.rate_kes" aria-describedby="rate_kes"
                            placeholder="Enter the Rate in Kenyan Shillings">
                        @error('event_order.rate_kes')
                            <small id="rate_kes" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="col-md-6 col-12">
                    <div class="mb-3">
                        <label for="table_setup" class="form-label">Table Setup</label>
                        <input wire:model="event_order.table_setup" type="text" class="form-control"
                            name="table_setup" id="table_setup" aria-describedby="table_setup"
                            placeholder="Enter the Style of Table Setup">
                        @error('event_order.table_setup')
                            <small id="table_setup" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="form-check">
                        <input wire:model="event_order.breakfast" class="form-check-input" type="checkbox"
                            value="" id="">
                        <label class="form-check-label" for="">
                            Breakfast
                        </label>
                    </div>
                    <div class="form-check">
                        <input wire:model="event_order.early_morning_tea" class="form-check-input" type="checkbox"
                            value="" id="">
                        <label class="form-check-label" for="">
                            Early Morning Tea
                        </label>
                    </div>
                    <div class="form-check">
                        <input wire:model="event_order.midmorning_tea" class="form-check-input" type="checkbox"
                            value="" id="">
                        <label class="form-check-label" for="">
                            Midmorning Tea
                        </label>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="form-check">
                        <input wire:model="event_order.lunch" class="form-check-input" type="checkbox"
                            value="" id="">
                        <label class="form-check-label" for="">
                            Lunch
                        </label>
                    </div>
                    <div class="form-check">
                        <input wire:model="event_order.afternoon_tea" class="form-check-input" type="checkbox"
                            value="" id="">
                        <label class="form-check-label" for="">
                            Afternoon Tea
                        </label>
                    </div>
                    <div class="form-check">
                        <input wire:model="event_order.dinner" class="form-check-input" type="checkbox"
                            value="" id="">
                        <label class="form-check-label" for="">
                            Dinner
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5 class="my-3">Descriptions</h5>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="meals" class="form-label">Meals and Menu</label>
                        <textarea wire:model="event_order.meals" class="form-control" name="meals" id="meals" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="beverages" class="form-label">Beverages</label>
                        <textarea wire:model="event_order.beverages" class="form-control" name="beverages" id="beverages" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="seminar_room" class="form-label">Seminar Room</label>
                        <textarea wire:model="event_order.seminar_room" class="form-control" name="seminar_room" id="seminar_room"
                            rows="3"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="equipment" class="form-label">Equipment</label>
                        <textarea wire:model="event_order.equipment" class="form-control" name="equipment" id="equipment" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="additions" class="form-label">Additional Notes</label>
                        <textarea wire:model="event_order.additions" class="form-control" name="additions" id="additions" rows="5"></textarea>
                    </div>
                </div>
            </div>
            <button wire:click="save" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>

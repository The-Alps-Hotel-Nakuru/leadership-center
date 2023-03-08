<div>
    <x-slot name="header">
        Event's Overview
    </x-slot>
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-6 col-12">
            <a href="{{ route('today-event-summary') }}" target="_blank" wire:click="generateToday"
                class="btn btn-primary my-3">
                <i class="fa fa-file-pdf"></i>
                Generate Today's Report
            </a>
        </div>
    </div>

    <div class="row flex-grow-1">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">New Event Orders</h6>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-12 col-xl-5">
                            <h3 class="mb-2">{{ $newOrders }}</h3>
                        </div>
                        <div class="col-6 col-md-12 col-xl-7">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">Today's Lunch Attendance</h6>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-12 col-xl-5">
                            <h3 class="mb-2">{{ $lunch_today }}</h3>
                        </div>
                        <div class="col-6 col-md-12 col-xl-7">
                            <b><u>Groups</u></b>
                            <ul>
                                @foreach ($groups_lunch as $group)
                                    <li>{{ $group }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">Today's Dinner Attendance</h6>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-12 col-xl-5">
                            <h3 class="mb-2">{{ $dinner_today }}</h3>
                        </div>
                        <div class="col-6 col-md-12 col-xl-7">
                            <b><u>Groups</u></b>
                            <ul>
                                @foreach ($groups_dinner as $group)
                                    <li>{{ $group }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <h4>List of Event Orders</h4>
            <p class="my-2">
                {{ $event_orders->links() }}
            </p>
        </div>
        <div class="table-responsive card-body">
            <table class="table table-hover table-borderless align-middle">
                <thead>

                    <tr>
                        <th>Event Number</th>
                        <th>Group Name</th>
                        <th>No. Of Pax</th>
                        <th>Period</th>
                        <th>Number of Days</th>
                        <th>Total Earned</th>
                        <th>Conference Hall(s)</th>
                        <th>Date Created</th>

                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($event_orders as $order)
                        <tr>
                            <td scope="row">Event #{{ sprintf('%04u', $order->id) }}</td>
                            <td>{{ $order->organization_name }}</td>
                            <td>{{ $order->pax }} People</td>
                            <td scope="row">from
                                <strong>{{ Carbon\Carbon::parse($order->start_date)->format("l jS M, 'y") }} </strong>
                                to <strong>{{ Carbon\Carbon::parse($order->end_date)->format("l jS M, 'y") }}</strong>
                            </td>
                            <td>
                                {{ $order->days }} Days
                            </td>
                            <td>
                               KES {{ number_format($order->earnings, 2) }}
                            </td>
                            <td>
                                <ul>
                                    @foreach ($order->conferenceHalls as $item)
                                        <li>{{ $item->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($order->created_at)->format("d\\M\\Y h:i:sA") }}
                            </td>
                            <td>
                                <div class="d-flex flex-row justify-content-center">
                                    <div class="flex-col m-1">
                                        <a href="{{ route('admin.event-orders.edit', $order->id) }}"
                                            class="btn btn-secondary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div>
                                    <div class="flex-col m-1">
                                        <button onclick="confirm('Are You Sure you want to Delete the Event Order #{{ sprintf('%04u', $order->id) }}')|| event.stopImmediatePropagation()" wire:click="delete({{ $order->id }})" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $event_orders->links() }}
        </div>

    </div>
</div>

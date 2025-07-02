<div>
    <x-slot name="header">Employees' Details</x-slot>



    <div class="d-flex mb-3">
        <button class="btn btn-dark" wire:loading.attr="disabled" wire:target="exportNssfData"
            wire:click="exportNssfData">
            <span wire:loading.remove wire:target="exportNssfData">
                Export NSSF Data
            </span>
            <span wire:loading wire:target="exportNssfData">
                Exporting...
            </span>
        </button>

        <button class="btn btn-success ms-2" wire:loading.attr="disabled" wire:target="exportNhifData"
            wire:click="exportNhifData">
            <span wire:loading.remove wire:target="exportNhifData">
                Export NHIF Data
            </span>
            <span wire:loading wire:target="exportNhifData">
                Exporting...
            </span>
        </button>

        <button class="btn btn-primary ms-2" wire:loading.attr="disabled" wire:target="exportKraData"
            wire:click="exportKraData">
            <span wire:loading.remove wire:target="exportKraData">
                Export KRA Data
            </span>
            <span wire:loading wire:target="exportKraData">
                Exporting...
            </span>
        </button>

        <button class="btn btn-primary ms-auto" wire:loading.attr="disabled" wire:target="downloadEmployeesTemplate"
            wire:click="downloadEmployeesTemplate">
            <span wire:loading.remove wire:target="downloadEmployeesTemplate">
                Download Employees Mass Addition Template
            </span>
            <span wire:loading wire:target="downloadEmployeesTemplate">
                Downloading...
            </span>
        </button>
    </div>
    <div class=" mb-3">
        <div class="card-body">
            <div class="row">
                <label for="" class="form-label">
                    <h4>Search an Employee </h4>
                </label>
                <input wire:model.live="search" type="text" class="form-control" name="" id=""
                    aria-describedby="helpId" placeholder="Search By Name">

            </div>
        </div>
    </div>
    <div class="table-responsive card">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Basic Details</th>
                    <th scope="col">Designation</th>
                    <th scope="col" class="text-center">Contract Status</th>
                    <th scope="col" class="text-center">Leave Balance</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $key => $employee)
                    <tr class="">
                        <td>{{ $employee->id }}</td>
                        <td>
                            <div class="d-flex flex-row">
                                <div class="flex-col">
                                    <img src="{{ $employee->user->profile_photo_url }}" class="img-fluid rounded-circle"
                                        width="60px" alt="">
                                </div>
                                <div class=" flex-col mx-3">
                                    <h5>{{ $employee->user->name }}</h5>
                                    <h6>{{ $employee->national_id }}</h6>
                                    <small>{{ $employee->user->email }}</small><br>
                                    <small>{{ $employee->phone_number }}</small><br>
                                    <small>Gender: <span
                                            class="text-capitalize">{{ $employee->gender }}</span></small><br>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-row">
                                <div class="flex-col">
                                    <h6>{{ $employee->designation->title }}</h6>
                                    <small>{{ $employee->designation->department->title }}</small>
                                </div>
                            </div>

                        </td>
                        <td>
                            <ul class="list-unstyled">
                                @foreach (App\Models\LeaveType::all() as $leaveType)
                                    @if ($employee->isLegibleforLeave($leaveType->id))
                                        <li>{{ $leaveType->title }}: {{ number_format(floor($employee->getLeaveBalance($leaveType->id))) }} days</li>
                                    @endif
                                @endforeach
                            </ul>

                        </td>
                        <td class="text-center">
                            @if ($employee->has_left)
                                <span class="badge rounded-pill bg-danger p-1 text-white text-uppercase">HAS
                                    LEFT</span>
                            @else
                                @if ($employee->has_active_contract)
                                    @if ($employee->is_banned)
                                        <span
                                            class="badge rounded-pill bg-danger p-1 text-white text-uppercase">Banned</span>
                                    @else
                                        <span
                                            class="badge rounded-pill bg-success p-1 text-white text-uppercase">Active</span>
                                    @endif
                                @else
                                    <span
                                        class="badge rounded-pill bg-warning p-1 text-white text-uppercase">Inactive</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-row justify-content-center">
                                <div class="flex-col mx-1">
                                    @foreach ($employee->contracts as $contract)
                                        @if ($contract->is_active)
                                            <a href="{{ route('admin.employee_contracts.edit', $contract->id) }}"
                                                class="btn btn-light shadow-sm"><i
                                                    class="bi bi-file-earmark-medical"></i></a>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="flex-col mx-1"><a href="{{ route('admin.employees.show', $employee->id) }}"
                                        class="btn btn-dark"><i class="bi bi-person-vcard"></i></a></div>
                                <div class="flex-col mx-1"><a href="{{ route('admin.employees.edit', $employee->id) }}"
                                        class="btn btn-secondary"><i class="bi bi-pencil"></i></a></div>
                                <div class="flex-col mx-1">
                                    <button
                                        onclick="confirm('Are you sure you want to Reset this Employee\'s Password?')||event.stopImmediatePropagation()"
                                        wire:click="resetPassword({{ $employee->user_id }})" class="btn btn-warning"><i
                                            class="bi bi-unlock"></i>
                                    </button>
                                </div>
                                <div class="flex-col mx-1">
                                    @if (!$employee->is_banned)
                                        <!-- Modal trigger button -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#banEmployee{{ $employee->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <!-- Modal Body -->
                                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                        <div wire:ignore class="modal fade" id="banEmployee{{ $employee->id }}"
                                            tabindex="-1" data-bs-keyboard="false" role="dialog"
                                            aria-labelledby="modalTitleId" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalTitleId">Ban
                                                            {{ $employee->user->name }}</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="reason" class="form-label">Reason</label>
                                                            <textarea placeholder="Enter your Reason" wire:model.live='reason' class="form-control" name="reason" id="reason"
                                                                rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="confirm('Are you sure you want to ban this Employee?')||event.stopImmediatePropagation()"
                                                            wire:click='banEmployee({{ $employee->id }})'>Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <button
                                            onclick="confirm('Are you sure you want to unban this Employee\'s Login?')||event.stopImmediatePropagation()"
                                            wire:click="unban({{ $employee->ban->id }})" class="btn btn-secondary"><i
                                                class="bi bi-unlock"></i>{{ $employee->ban->id }}
                                        </button>
                                    @endif


                                </div>
                                <div class="flex-col mx-1">
                                    @if (!$employee->has_left)
                                        <a href="{{ route('admin.employees.mark-exit', $employee->id) }}"
                                            class="btn btn-dark text-danger"><i class="bi bi-box-arrow-left"></i></a>
                                    @else
                                        <button
                                            onclick="confirm('Are you sure you want to restore this employee?')||event.stopImmediatePropagation()"
                                            wire:click="restoreEmployee({{ $employee->id }})"
                                            class="btn btn-dark text-success"><i
                                                class="bi bi-box-arrow-right"></i></button>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="my-3"> {{ $employees->links() }}</div>

    @foreach (App\Models\EmployeesDetail::all() as $employee)
        @if (!$employee->bankAccount)
            <p>The Following do not have bank accounts set</p>
        @break
    @endif
@endforeach
<ol>
    @foreach (App\Models\EmployeesDetail::all() as $employee)
        @if (!$employee->bankAccount)
            <li>{{ $employee->user->name }}</li>
        @endif
    @endforeach

</ol>
</div>

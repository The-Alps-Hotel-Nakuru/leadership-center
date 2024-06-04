<div>
    <x-slot name="header">
        Employees Contracts
    </x-slot>

    <div class="container-fluid">
        <div class=" mb-3">
            <div class="card-body">
                <div class="row">
                    <label for="" class="form-label">
                        <h4>Search an Employee </h4>
                    </label>
                    <input wire:model="searchEmployee" type="text" class="form-control" name="" id=""
                        aria-describedby="helpId" placeholder="Search By Name">

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex bg-transparent border-0">
                <h5>List of Employees Active Contracts</h5>
                <div class="flex-col ml-auto">
                    <a wire:ignore href="{{ route('admin.employee_contracts.create') }}" class="btn btn-primary">
                        <i class="fas fa-file-pdf"></i>
                    </a>

                </div>
                <div class="flex-col mx-2">
                    <select class="form-control" wire:model='type' name="" id="">
                        <option value="all">All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="flex-col mx-2">
                    <div class="form-group">
                        <input type="date" class="form-control" wire:model="date" name="" id=""
                            aria-describedby="helpId" placeholder="">
                        @error('date')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <x-jet-confirms-password wire:then="makeAllInactive">
                        <x-jet-button type="button" wire:loading.attr="disabled" >Make All Active contracts
                            Inactive</x-jet-button>
                    </x-jet-confirms-password>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Contract No.</th>
                            <th scope="col">ID</th>
                            <th scope="col">Employee's Name & Designation</th>
                            <th scope="col">Appointment Date</th>
                            <th scope="col">Expiry Date</th>
                            <th scope="col">Remuneration</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contracts as $key => $contract)
                            <tr class="">
                                <td>{{ $contract->id }}</td>
                                <td>{{ $contract->employee->id }}</td>
                                <td>
                                    <div class="d-flex flex-row">
                                        <div class="flex-col">
                                            <h5>{{ $contract->employee->user->name }}</h5>
                                            <small>{{ $contract->employee->designation->title }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ Carbon\Carbon::parse($contract->start_date)->format('jS \of F, Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($contract->end_date)->format('jS \of F, Y') }}</td>
                                <td>KES {{ number_format($contract->salary_kes) }} <small>(@if ($contract->employment_type_id == 1)
                                            per day
                                        @else
                                            per month
                                        @endif)</small></td>

                                <td>
                                    <div class="d-flex flex-row justify-content-center">
                                        @if ($contract->contract_path)
                                            <a target="_blank" href="javascript:;" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View Unsigned Contract"
                                                class="btn btn-success m-1">
                                                <i class="fas fa-file-contract"></i>
                                            </a>
                                        @else
                                            <a target="_blank" href="{{ route('doc.contract', $contract->id) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="View Signed Contract" class="btn btn-light shadow-sm m-1">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.employee_contracts.edit', $contract->id) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Contract"
                                            class="btn btn-warning m-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button wire:click="makeInactive({{ $contract->id }})" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Terminate Contract" class="btn btn-dark m-1">
                                            <i class="fas fa-stop-circle"></i>
                                        </button>
                                        <button
                                            onclick="confirm('Are you sure you want to Delete this contract?')||event.stopImmediatePropagation()"
                                            wire:click="delete({{ $contract->id }})" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete Contract" class="btn btn-danger m-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="my-2">
            {{ $contracts->links() }}
        </div>
    </div>
</div>

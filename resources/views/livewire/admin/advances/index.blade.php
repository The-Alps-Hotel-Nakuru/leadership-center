<div>
    <x-slot name="header">
        Advances Overview
    </x-slot>

    <div class="container-fluid">
        <div class="card-header d-flex">
            <button class="btn btn-secondary ms-auto me-2" wire:loading.attr="disabled" wire:target="downloadTemplate"
                wire:click="downloadTemplate">
                <span wire:loading.remove wire:target="downloadTemplate">
                    Download Advances Template
                </span>
                <span wire:loading wire:target="downloadTemplate">
                    Downloading...
                </span>
            </button>
            <button class="btn btn-warning" wire:loading.attr="disabled" wire:target="downloadAdvancesData"
                wire:click="downloadAdvancesData">
                <span wire:loading.remove wire:target="downloadAdvancesData">
                    Download Advances Data
                </span>
                <span wire:loading wire:target="downloadAdvancesData">
                    Downloading...
                </span>
            </button>
        </div>
        <div class="card">
            <div class="card-header d-flex">
                <h5>List of Issued Advances</h5>
                <a href="{{ route('admin.advances.create') }}" class="btn btn-primary ml-auto">Create New</a>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Employee</th>
                            <th scope="col">Month Issued</th>
                            <th scope="col">Amount <small>(KES)</small></th>
                            <th scope="col">Reason</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($advances as $key => $advance)
                            <tr class="">
                                <td>{{ $advances->firstItem() + $key }}</td>
                                <td scope="row">{{ $advance->employee->user->name }}</td>
                                <td>{{ Carbon\Carbon::parse($advance->year . '-' . $advance->month)->format('F, Y') }}
                                </td>
                                <td>KES {{ number_format($advance->amount_kes) }}</td>
                                <td>{{ $advance->reason }}</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <div class="flex-col me-2">
                                        <a href="{{ route('admin.advances.edit', $advance->id) }}"
                                            class="btn btn-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                    <div class="flex-col">
                                        <button class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="my-3"> {{ $advances->links() }}</div>
        </div>
    </div>
</div>

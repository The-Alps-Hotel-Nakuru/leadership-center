<div>
    <x-slot name="header">
        Fines Overview
    </x-slot>

    <div class="container-fluid">
        <div class="card-header d-flex">
            <button class="btn btn-secondary ms-auto me-2"  wire:loading.attr="disabled" wire:target="downloadTemplate"
                wire:click="downloadTemplate">
                <span wire:loading.remove wire:target="downloadTemplate">
                    Download Fines Template
                </span>
                <span wire:loading wire:target="downloadTemplate">
                    Downloading...
                </span>
            </button>
            <button class="btn btn-warning"  wire:loading.attr="disabled" wire:target="downloadFinesData"
                wire:click="downloadFinesData">
                <span wire:loading.remove wire:target="downloadFinesData">
                    Download Fines Data
                </span>
                <span wire:loading wire:target="downloadFinesData">
                    Downloading...
                </span>
            </button>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>List of Issued Fines</h5>
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
                        @foreach ($fines as $key => $fine)
                            <tr class="">
                                <td >{{ $fines->firstItem() + $key }}</td>
                                <td scope="row">{{ $fine->employee->user->name }}</td>
                                <td>{{ Carbon\Carbon::parse($fine->year . '-' . $fine->month)->format('F, Y') }}</td>
                                <td>KES {{ number_format($fine->amount_kes) }}</td>
                                <td>{{ ($fine->reason) }}</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <div class="flex-col m-1">
                                        <a href="{{ route('admin.fines.edit', $fine->id) }}"
                                            class="btn btn-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                    <div class="flex-col m-1">
                                        <button class="btn btn-danger" wire:click="delete({{ $fine->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="my-3"> {{ $fines->links() }}</div>
        </div>
    </div>
</div>

<div>
    <x-slot name="header">
        Bonuses Overview
    </x-slot>

    <div class="container-fluid">
        <div class="my-3 d-flex">
            <button class="btn btn-primary ml-auto" wire:loading.attr="disabled" wire:target="downloadBonusesTemplate"
                wire:click="downloadBonusesTemplate">
                <span wire:loading.remove wire:target="downloadBonusesTemplate">
                    Download Bonuses Mass Addition Template
                </span>
                <span wire:loading wire:target="downloadBonusesTemplate">
                    Downloading...
                </span>
            </button>
        </div>
        <div class="card">
            <div class="card-header d-flex">
                <h5>List of Issued Bonuses</h5>
                <div class="flex-row ml-auto">
                    <a href="{{ route('admin.bonuses.create') }}" class="btn btn-primary">Create New</a>
                    <a href="{{ route('admin.bonuses.mass_addition') }}" class="btn btn-secondary ">Create Many</a>
                </div>
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
                        @foreach ($bonuses as $key => $bonus)
                            <tr class="">
                                <td>{{ $bonuses->firstItem() + $key }}</td>
                                <td scope="row">{{ $bonus->employee->user->name }}</td>
                                <td>{{ Carbon\Carbon::parse($bonus->year . '-' . $bonus->month)->format('F, Y') }}</td>
                                <td>KES {{ number_format($bonus->amount_kes) }}</td>
                                <td>{{ $bonus->reason }}</td>
                                <td class="text-center">

                                    <a href="{{ route('admin.bonuses.edit', $bonus->id) }}" class="btn btn-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button
                                        onclick="confirm('Are you sure you wish to delete this Bonus record?')||event.stopImmediatePropagation()"
                                        class="btn btn-danger" wire:click='delete({{ $bonus->id }})'>
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="my-3"> {{ $bonuses->links() }}</div>


        </div>
    </div>
</div>

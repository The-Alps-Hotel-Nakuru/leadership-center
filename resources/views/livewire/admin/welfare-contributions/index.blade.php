<div>
    <x-slot name="header">
        Bonuses Overview
    </x-slot>

    <div class="container-fluid">
        <div class="card-header d-flex">
            <button class="btn btn-primary ms-auto"  wire:loading.attr="disabled" wire:target="downloadWelfareContributionsData"
                wire:click="downloadWelfareContributionsData">
                <span wire:loading.remove wire:target="downloadWelfareContributionsData">
                    Download Staff Welfare Breakdown
                </span>
                <span wire:loading wire:target="downloadWelfareContributionsData">
                    Downloading...
                </span>
            </button>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>List of Issued Welfare Contributions</h5>
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
                        @foreach ($welfare_contributions as $key => $welfare_contribution)
                            <tr class="">
                                <td>{{ $welfare_contributions->firstItem() + $key }}</td>
                                <td scope="row">{{ $welfare_contribution->employee->user->name }}</td>
                                <td>{{ Carbon\Carbon::parse($welfare_contribution->year . '-' . $welfare_contribution->month)->format('F, Y') }}</td>
                                <td>KES {{ number_format($welfare_contribution->amount_kes) }}</td>
                                <td>{{ $welfare_contribution->reason }}</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <div class="flex-col me-2">
                                        <a href="{{ route('admin.welfare_contributions.edit', $welfare_contribution->id) }}"
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
            <div class="my-3"> {{ $welfare_contributions->links() }}</div>


        </div>
    </div>
</div>

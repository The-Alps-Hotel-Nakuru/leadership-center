<div>
    <x-slot name="header">
        Bonuses Overview
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>List of Issued Bonuses</h5>
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
                                <td>{{ ($bonus->reason) }}</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <div class="flex-col me-2">
                                        <a href="{{ route('admin.bonuses.edit', $bonus->id) }}"
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
            <div class="my-3"> {{ $bonuses->links() }}</div>
        </div>
    </div>
</div>

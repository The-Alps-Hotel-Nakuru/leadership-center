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
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bonuses as $bonus)
                            <tr class="">
                                <td scope="row">{{ $bonus->id }}</td>
                                <td scope="row">{{ $bonus->employee->user->name }}</td>
                                <td>{{ Carbon\Carbon::parse($bonus->year . '-' . $bonus->month)->format('F, Y') }}</td>
                                <td>KES {{ number_format($bonus->amount_kes) }}</td>
                                <td class="d-flex flex-row">
                                    <div class="flex-col">
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
        </div>
    </div>
</div>

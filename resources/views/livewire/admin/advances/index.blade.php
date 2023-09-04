<div>
    <x-slot name="header">
        Advances Overview
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>List of Issued Advances</h5>
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
                                <td>{{ Carbon\Carbon::parse($advance->year . '-' . $advance->month)->format('F, Y') }}</td>
                                <td>KES {{ number_format($advance->amount_kes) }}</td>
                                <td>{{ ($advance->reason) }}</td>
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

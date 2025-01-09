<div>
    <x-slot name="header">
        Biometrics Overview
    </x-slot>

    <div class="container-fluid">

        <div class="card">
            <div class="card-header d-flex">
                <h5>List of Issued Biometrics</h5>
                <div class="flex-row ms-auto">
                    <a href="{{ route('admin.biometrics.create') }}" class="btn btn-primary">Create New</a>
                    <a href="{{ route('admin.biometrics.mass_addition') }}" class="btn btn-secondary ">Create Many</a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Employee</th>
                            <th scope="col">Biometric ID</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($biometrics as $key => $biometric)
                            <tr class="">
                                <td>{{ $biometrics->firstItem() + $key }}</td>
                                <td scope="row">{{ $biometric->employee->user->name }}</td>
                                <td scope="row">{{ $biometric->biometric_id }}</td>
                                <td class="d-flex flex-row justify-content-center">
                                    <div class="flex-col me-2">
                                        <a href="{{ route('admin.biometrics.edit', $biometric->id) }}"
                                            class="btn btn-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                    <div class="flex-col">
                                        <button wire:click='delete({{ $biometric->id }})' class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="my-3"> {{ $biometrics->links() }}</div>


        </div>
    </div>
</div>

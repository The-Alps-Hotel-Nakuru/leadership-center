<div>
    <x-slot name="header">
        Departments Overview
    </x-slot>
    <div class="container-fluid">
        <div class="card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Designation Title</th>
                            <th scope="col">Department</th>
                            <th scope="col">Number of Employees</th>
                            <th scope="col">Legible for Attendance Penalty</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($designations as $key => $designation)
                            <tr class="">
                                <td>{{ $designations->firstItem() + $key }}</td>
                                <td>{{ $designation->title }}</td>
                                <td class="text-secondary text-uppercase">{{ $designation->department->title }}</td>
                                <td><strong>{{ count($designation->employees) }}</strong> employees</td>
                                <td><strong class="text-{{  $designation->is_penalizable==1?'success':'danger' }}">{{ $designation->is_penalizable==1?'Is Penalizable':'Is not Penalizable' }}</strong></td>
                                <td class="d-flex flex-row justify-content-center">
                                    <div class="flex-col mx-2">
                                        <a href="{{ route('admin.designations.edit', $designation->id) }}"
                                            class="btn btn-secondary"><i class="fas fa-edit"></i></a>
                                    </div>
                                    <div class="flex-col mx-2">
                                        <button class="btn btn-danger" onclick="confirm('Are you Sure You want to delete the designation?')||event.stopImmediatePropagation()" wire:click="delete({{ $designation->id }})"><i
                                                class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="my-3"> {{ $designations->links() }}</div>
        </div>
    </div>
</div>

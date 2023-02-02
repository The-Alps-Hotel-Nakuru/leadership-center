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
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($designations as $designation)
                            <tr class="">
                                <td scope="row">{{ $designation->id }}</td>
                                <td>{{ $designation->title }}</td>
                                <td class="text-secondary text-uppercase">{{ $designation->department->title }}</td>
                                <td><strong>{{ count($designation->employees) }}</strong> employees</td>
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

        </div>
    </div>
</div>

<div>
    <x-slot name="header">List of Banks</x-slot>

    <div class="table-responsive card">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Bank Name</th>
                    <th scope="col">Bank Short Name</th>
                    <th scope="col" class="text-center">Bank SORT Code</th>
                    <th scope="col" class="text-center">Number of Banks</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banks as $key => $bank)
                    <tr class="">
                        <td>{{ $bank->id }}</td>
                        <td>
                            {{ $bank->name }}
                        </td>
                        <td>
                            {{ $bank->short_name }}
                        </td>
                        <td class="text-center">
                            {{ $bank->bank_code }}
                        </td>
                        <td>
                            <div class="d-flex flex-row justify-content-center">
                                <div class="flex-col mx-1">
                                    <a href="{{ route('admin.banks.edit', $bank->id) }}"
                                        class="btn btn-secondary"><i class="fas fa-edit"></i></a>
                                </div>
                                <div class="flex-col mx-1">
                                    <button
                                        onclick="confirm('Are you sure you want to delete this Bank?')||event.stopImmediatePropagation()"
                                        wire:click="delete({{ $bank->id }})" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $banks->links() }}
</div>

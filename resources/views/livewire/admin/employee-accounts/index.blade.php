<div>
    <x-slot:header>
        Employees Accounts
    </x-slot:header>

    <div class="card">
        <div class="card-header">
            <h5>List of Employees' Accounts</h5>
        </div>
        <div class="table-responsive card-body">
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Designation</th>
                        <th scope="col">Account Number</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($employees_accounts as $account)
                        <tr class="">
                            <td scope="row">{{ $account->id }}</td>
                            <td>{{ $account->employee->user->name }}</td>
                            <td>{{ $account->employee->designation->title }}</td>
                            <td>{{ $account->bank->name }} <br> {{ $account->account_number }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

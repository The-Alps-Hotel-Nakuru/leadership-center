<div>
    <x-slot name="header"> Payroll Breakdown for
        {{ Carbon\Carbon::parse($payroll->year . '-' . $payroll->month)->format('F Y') }}</x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Full Time Employees</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Net Pay</th>
                            <th scope="col">NHIF Premium</th>
                            <th scope="col">NSSF Contribution</th>
                            <th scope="col">Total Gross Pay</th>
                            <th scope="col">Extra Additions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payroll->monthlySalaries as $salary)
                            <tr class="">
                                <td scope="row">R1C1</td>
                                <td>R1C2</td>
                                <td>R1C3</td>
                                <td>R1C3</td>
                                <td>R1C3</td>
                                <td>R1C3</td>
                                <td>R1C3</td>
                                <td>R1C3</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

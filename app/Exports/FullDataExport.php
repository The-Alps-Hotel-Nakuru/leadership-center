<?php

namespace App\Exports;

use App\Exports\FullDataExport\Departments;
use App\Exports\FullDataExport\Designations;
use App\Exports\FullDataExport\Employees;
use App\Exports\FullDataExport\EmploymentTypes;
use App\Exports\FullDataExport\LeaveTypes;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FullDataExport implements WithMultipleSheets
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function sheets(): array
    {
        return [
            new Departments(),
            new Designations(),
            // new Employees(),
            // new EmploymentTypes(),
            // new Contracts(),
            // new LeaveTypes(),
            // new Leaves(),
            // new Holidays(),
            // new Attendances(),
            // new Bonuses(),
            // new Fines(),
            // new Loans(),
            // new LeaveTypes(),
            // new LeaveRequests(),
            // new LeavesFromRequests(),
            // new Salaries(),
            // new Payrolls(),
            // new Payments(),
        ];
    }
}

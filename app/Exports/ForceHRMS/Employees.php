<?php

namespace App\Exports\ForceHRMS;

use App\Models\EmployeesDetail;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class Employees implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Employees';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'first_name',
            'last_name',
            'email',
            'designation',
            'phone_number',
            'date_of_birth',
            'gender',
            'national_id',
            'date_of_employment',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $employees = EmployeesDetail::with(['user', 'designation', 'contracts'])->get();

        return $employees->map(function ($employee) {
            // Get the earliest contract start date as employment date if exists
            $employmentDate = $employee->contracts()
                ->orderBy('start_date', 'asc')
                ->first()
                ?->start_date;

            return [
                $employee->user->first_name ?? '',
                $employee->user->last_name ?? '',
                $employee->user->email ?? '',
                $employee->designation->title ?? '',
                $employee->phone_number ?? '',
                $employee->birth_date ? Carbon::parse($employee->birth_date)->format('Y-m-d') : '',
                $employee->gender ?? '',
                $employee->national_id ?? '',
                $employmentDate ? Carbon::parse($employmentDate)->format('Y-m-d') : '',
            ];
        });
    }
}

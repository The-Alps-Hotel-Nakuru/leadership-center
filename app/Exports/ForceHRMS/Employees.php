<?php

namespace App\Exports\ForceHRMS;

use App\Models\EmployeesDetail;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

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
            'First Name',
            'Last Name',
            'National ID',
            'KRA PIN',
            'NSSF',
            'NHIF',
            'Email',
            'Phone Number',
            'Date of Birth',
            'Gender',
            'Marital Status',
            'Designation',
            'Physical Address',
            'Bank',
            'Bank Account Number',
            'Recruitment Date',
            'Exit Date',
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
                $employee->national_id ?? '',
                $employee->kra_pin ?? '',
                $employee->nssf ?? '',
                $employee->nhif ?? '',
                $employee->user->email ?? '',
                $employee->phone_number ?? '',
                $employee->birth_date ? Carbon::parse($employee->birth_date)->format('Y-m-d') : '',
                $employee->gender ?? '',
                $employee->marital_status ?? '',
                $employee->designation->title ?? '',
                $employee->physical_address ?? '',
                $employee->bankAccount->bank->name ?? '', // bank - not in database
                $employee->bankAccount->account_number ?? '', // bank_account_number - not in database
                $employee->recruitment_date ? Carbon::parse($employee->recruitment_date)->format('Y-m-d') : '',
                $employee->exit_date ? Carbon::parse($employee->exit_date)->format('Y-m-d') : '',
            ];
        });
    }
}

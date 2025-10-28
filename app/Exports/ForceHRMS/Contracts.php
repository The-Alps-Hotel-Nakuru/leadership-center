<?php

namespace App\Exports\ForceHRMS;

use App\Models\EmployeeContract;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Contracts implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Contracts';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Employee Email',
            'Employment Type',
            'Start Date',
            'End Date',
            'Salary (KES)',
            'Weekly Offs',
            'Is Taxable',
            'Is Net Salary',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $contracts = EmployeeContract::with(['employee.user', 'employment_type'])->get();

        return $contracts->map(function ($contract) {
            $terms = "Type: {$contract->employment_type->title}, Salary: {$contract->salary_kes} KES";
            if ($contract->weekly_offs) {
                $terms .= ", Weekly Offs: {$contract->weekly_offs}";
            }

            return [
                $contract->employee->user->email ?? '',
                $contract->employment_type->title ?? '',
                Carbon::parse($contract->start_date)->format('Y-m-d'),
                $contract->end_date ? Carbon::parse($contract->end_date)->format('Y-m-d') : '',
                $contract->salary_kes ?? '',
                $contract->weekly_offs ?? '',
                $contract->is_taxable ? true : false,
                $contract->is_net ? true : false,
            ];
        });
    }
}

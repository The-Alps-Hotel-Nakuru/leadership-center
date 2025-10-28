<?php

namespace App\Exports\ForceHRMS;

use App\Models\LoanDeduction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class LoanDeductions implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'LoanDeductions';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Loan ID',
            'Employee Email',
            'Date',
            'Amount',
            'Reason',
            'Created At',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $loanDeductions = LoanDeduction::with(['employee.user'])->get();

        return $loanDeductions->map(function ($loanDed) {
            // Construct date from year and month
            $date = Carbon::createFromDate($loanDed->year, $loanDed->month, 1)->format('Y-m-d');

            return [
                $loanDed->loan_id,
                $loanDed->loan->employee->user->email ?? '',
                $date,
                $loanDed->amount ?? '',
                $loanDed->reason ?? '',
                $loanDed->created_at ? Carbon::parse($loanDed->created_at)->format('Y-m-d H:i:s') : '',
            ];
        });
    }
}

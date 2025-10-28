<?php

namespace App\Exports\ForceHRMS;

use App\Models\Loan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Loans implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Loans';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Employee Email',
            'Year',
            'Month',
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
        $loans = Loan::with(['employee.user'])->get();

        return $loans->map(function ($loan) {
            // Construct date from year and month
            $date = Carbon::createFromDate($loan->year, $loan->month, 1)->format('Y-m-d');

            return [
                $loan->employee->user->email ?? '',
                $loan->year,
                $loan->month,
                $loan->amount_kes ?? '',
                $loan->reason . '- imported loan_id:' . $loan->id ?? '',
                $loan->created_at ? Carbon::parse($loan->created_at)->format('Y-m-d H:i:s') : '',
            ];
        });
    }
}

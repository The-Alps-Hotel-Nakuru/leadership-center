<?php

namespace App\Exports\ForceHRMS;

use App\Models\WelfareContribution;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class WelfareContributions implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'WelfareContributions';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Employee Email',
            'Date',
            'Amount',
            'Contribution Type',
            'Created At',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $contributions = WelfareContribution::with(['employee.user'])->get();

        return $contributions->map(function ($contribution) {
            // Construct date from year and month
            $date = Carbon::createFromDate($contribution->year, $contribution->month, 1)->format('Y-m-d');

            return [
                $contribution->employee->user->email ?? '',
                $date,
                $contribution->amount_kes ?? '',
                $contribution->reason ?? '',
                $contribution->created_at ? Carbon::parse($contribution->created_at)->format('Y-m-d H:i:s') : '',
            ];
        });
    }
}

<?php

namespace App\Exports\ForceHRMS;

use App\Models\Advance;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Advances implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Advances';
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
            'Reason',
            'Created At',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $advances = Advance::with(['employee.user'])->get();

        return $advances->map(function ($advance) {
            // Construct date from year and month
            $date = Carbon::createFromDate($advance->year, $advance->month, 1)->format('Y-m-d');

            return [
                $advance->employee->user->email ?? '',
                $date,
                $advance->amount_kes ?? '',
                $advance->reason ?? '',
                $advance->created_at ? Carbon::parse($advance->created_at)->format('Y-m-d H:i:s') : '',
            ];
        });
    }
}

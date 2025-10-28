<?php

namespace App\Exports\ForceHRMS;

use App\Models\Fine;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Fines implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Fines';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'employee_email',
            'date',
            'amount',
            'reason',
            'created_at',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $fines = Fine::with(['employee.user'])->get();

        return $fines->map(function ($fine) {
            // Construct date from year and month
            $date = Carbon::createFromDate($fine->year, $fine->month, 1)->format('Y-m-d');

            return [
                $fine->employee->user->email ?? '',
                $date,
                $fine->amount_kes ?? '',
                $fine->reason ?? '',
                $fine->created_at ? Carbon::parse($fine->created_at)->format('Y-m-d H:i:s') : '',
            ];
        });
    }
}

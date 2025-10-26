<?php

namespace App\Exports\ForceHRMS;

use App\Models\Bonus;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class Bonuses implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Bonuses';
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
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $bonuses = Bonus::with(['employee.user'])->get();

        return $bonuses->map(function ($bonus) {
            // Construct date from year and month
            $date = Carbon::createFromDate($bonus->year, $bonus->month, 1)->format('Y-m-d');

            return [
                $bonus->employee->user->email ?? '',
                $date,
                $bonus->amount_kes ?? '',
                $bonus->reason ?? '',
            ];
        });
    }
}

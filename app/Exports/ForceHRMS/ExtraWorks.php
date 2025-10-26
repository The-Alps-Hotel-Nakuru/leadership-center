<?php

namespace App\Exports\ForceHRMS;

use App\Models\ExtraWork;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExtraWorks implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'ExtraWorks';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'employee_email',
            'date',
            'hours',
            'description',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $extraWorks = ExtraWork::with(['employee.user'])->get();

        return $extraWorks->map(function ($extraWork) {
            // Calculate hours based on double_shift flag (e.g., 8 hours for single, 16 for double)
            $hours = $extraWork->double_shift ? 16 : 8;
            $description = $extraWork->double_shift ? 'Double Shift' : 'Extra Work';

            return [
                $extraWork->employee->user->email ?? '',
                Carbon::parse($extraWork->date)->format('Y-m-d'),
                $hours,
                $description,
            ];
        });
    }
}

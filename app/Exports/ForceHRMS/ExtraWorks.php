<?php

namespace App\Exports\ForceHRMS;

use App\Models\ExtraWork;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

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
            'Employee Email',
            'Date',
            'Double Shift',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $extraWorks = ExtraWork::with(['employee.user'])->get();

        return $extraWorks->map(function ($extraWork) {
            return [
                $extraWork->employee->user->email ?? '',
                Carbon::parse($extraWork->date)->format('Y-m-d'),
                $extraWork->double_shift ? "1" : "0",
            ];
        });
    }
}

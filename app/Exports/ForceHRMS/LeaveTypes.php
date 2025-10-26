<?php

namespace App\Exports\ForceHRMS;

use App\Models\LeaveType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LeaveTypes implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'LeaveTypes';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'name',
            'days_allowed',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Get all leave types
        $leaveTypes = LeaveType::all();

        return $leaveTypes->map(function ($type) {
            return [
                $type->title ?? '',
                $type->max_days ?? 0,
            ];
        });
    }
}

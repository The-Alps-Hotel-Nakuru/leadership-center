<?php

namespace App\Exports\ForceHRMS;

use App\Models\LeaveType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

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
            'Title',
            'Description',
            'Max Days',
            'Monthly Accrual Rate',
            'Min Months Worked',
            'Full Pay Days',
            'Half Pay Days',
            'Is Paid',
            'Can Accumulate',
            'Carry Forward Limit',
            'Is Gender Specific',
            'Gender',
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
                $type->description ?? '',
                $type->max_days ?? 0,
                $type->monthly_accrual_rate ?? 0.00,
                $type->min_months_worked ?? 0,
                $type->full_pay_days ?? 0,
                $type->half_pay_days ?? 0,
                $type->is_paid ? "1" : "0",
                $type->can_accumulate ? "1" : "0",
                $type->carry_forward_limit ?? 0,
                $type->is_gender_specific ? "1" : "0",
                $type->gender ?? '',
            ];
        });
    }
}

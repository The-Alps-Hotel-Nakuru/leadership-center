<?php

namespace App\Exports\ForceHRMS;

use App\Models\Leave;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Leaves implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Leaves';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'employee_email',
            'leave_type',
            'start_date',
            'end_date',
            'created_at',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $leaves = Leave::with(['employee.user', 'type'])->get();

        return $leaves->map(function ($leave) {
            $startDate = Carbon::parse($leave->start_date);
            $endDate = Carbon::parse($leave->end_date);
            $days = $startDate->diffInDays($endDate) + 1;

            return [
                $leave->employee->user->email ?? '',
                $leave->type->title ?? '',
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d'),
                $leave->created_at ? Carbon::parse($leave->created_at)->format('Y-m-d H:i:s') : '',
            ];
        });
    }
}

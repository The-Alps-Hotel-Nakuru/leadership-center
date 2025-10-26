<?php

namespace App\Exports\ForceHRMS;

use App\Models\Attendance;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class Attendances implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Attendances';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'employee_email',
            'date',
            'check_in',
            'check_out',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $attendances = Attendance::with(['employee.user'])->get();

        return $attendances->map(function ($attendance) {
            $checkInTime = $attendance->check_in ? Carbon::parse($attendance->check_in)->format('H:i:s') : '';
            $checkOutTime = $attendance->check_out ? Carbon::parse($attendance->check_out)->format('H:i:s') : '';

            return [
                $attendance->employee->user->email ?? '',
                Carbon::parse($attendance->date)->format('Y-m-d'),
                $checkInTime,
                $checkOutTime,
            ];
        });
    }
}

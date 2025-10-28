<?php

namespace App\Exports\ForceHRMS;

use App\Models\Ban;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Bans implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Bans';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Employee Email',
            'Reason',
            'Created At',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $bans = Ban::with(['employee.user'])->get();
        return $bans->map(function ($ban) {
            return [
                $ban->employee->user->email ?? '',
                $ban->reason ?? '',
                $ban->created_at ? Carbon::parse($ban->created_at)->format('Y-m-d H:i:s') : '',
            ];
        });
    }
}

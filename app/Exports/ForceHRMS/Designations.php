<?php

namespace App\Exports\ForceHRMS;

use App\Models\Designation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Designations implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Designations';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Title',
            'Department Name',
            'Is Penalizable',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $designations = Designation::with('department')->get();

        return $designations->map(function ($designation) {
            return [
                $designation->title ?? '',
                $designation->department->title ?? '',
                $designation->is_penalizable ? "1" : "0",
            ];
        });
    }
}

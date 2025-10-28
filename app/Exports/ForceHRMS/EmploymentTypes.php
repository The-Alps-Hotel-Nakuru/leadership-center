<?php

namespace App\Exports\ForceHRMS;

use App\Models\EmploymentType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class EmploymentTypes implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'EmploymentTypes';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Description',
            'Rate Type',
            'Penalizable',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Get all employment types used by employees
        $employmentTypes = EmploymentType::all();

        return $employmentTypes->map(function ($type) {
            return [
                $type->title ?? '',
                $type->description ?? '',
                $type->rate_type ?? '',
                $type->penalizable ? true : false,
            ];
        });
    }
}

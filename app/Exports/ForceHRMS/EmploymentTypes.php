<?php

namespace App\Exports\ForceHRMS;

use App\Models\EmploymentType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

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
            'name',
            'description',
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
            ];
        });
    }
}

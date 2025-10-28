<?php

namespace App\Exports\ForceHRMS;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Departments implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Departments';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Description',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $departments = Department::all();

        return $departments->map(function ($dept) {
            return [
                $dept->title ?? '',
                '',
            ];
        });
    }
}

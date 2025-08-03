<?php

namespace App\Exports\FullDataExport;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Designations implements FromCollection, WithTitle, ShouldAutoSize, WithHeadings
{
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Department ID',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function title(): string
    {
        return 'Designations';
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = [];
        foreach (\App\Models\Designation::all() as $key => $designation) {
            $data[] = [
                $designation->id,
                $designation->title,
                $designation->department_id,
                Carbon::parse($designation->created_at)->toDateString(),
                Carbon::parse($designation->updated_at)->toDateString(),
            ];
        }

        return collect($data);
    }
}

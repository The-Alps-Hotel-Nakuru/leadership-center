<?php

namespace App\Exports\FullDataExport;

use App\Models\Department;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Departments implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Departments';
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Created At',
            'Updated At',
        ];
    }
    public function collection()
    {
        $data = [];
        foreach (Department::all() as $key => $department) {
            $data[] = [
                $department->id,
                $department->title,
                Carbon::parse($department->created_at)->toDateString(),
                Carbon::parse($department->updated_at)->toDateString(),
            ];
        }
        return collect($data);
    }
}

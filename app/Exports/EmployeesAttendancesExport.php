<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat as StyleNumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeesAttendancesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithColumnFormatting, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([]);
    }

    public function title(): string
    {
        return "Attendances Mass Addition";
    }

    public function headings(): array
    {
        $expectedFields = ["Emp No.", "AC-No.", "No.", "Name", "Auto-Assign", "Date", "Timetable", "On duty", "Off duty", "Clock In", "Clock Out", "Normal", "Real time", "Late", "Early", "Absent", "OT Time", "Work Time", "Exception", "Must C/In", "Must C/Out", "Department", "NDays", "WeekEnd", "Holiday", "ATT_Time", "NDays_OT", "WeekEnd_OT", "Holiday_OT"];
        return $expectedFields;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12]
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => StyleNumberFormat::FORMAT_NUMBER,
            'B' => StyleNumberFormat::FORMAT_NUMBER,
            'C' => StyleNumberFormat::FORMAT_NUMBER,
            'D' => StyleNumberFormat::FORMAT_TEXT,
            'E' => StyleNumberFormat::FORMAT_TEXT,
            'F' => StyleNumberFormat::FORMAT_TEXT,
            'G' => StyleNumberFormat::FORMAT_TEXT,
            'H' => StyleNumberFormat::FORMAT_TEXT,
            'I' => StyleNumberFormat::FORMAT_TEXT,
        ];
    }
}


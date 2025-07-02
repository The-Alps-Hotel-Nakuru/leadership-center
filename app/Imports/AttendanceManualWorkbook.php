<?php

namespace App\Imports;

use App\Models\Attendance;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AttendanceManualWorkbook implements WithMultipleSheets
{
    protected $data = [];
    protected $sheetNames = [];

    public function __construct(array $sheetNames)
    {
        $this->sheetNames = $sheetNames;
    }
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->sheetNames as $sheetName) {
            $sheets[$sheetName] = new ManualSheetImport($sheetName, $this);
        }

        return $sheets;
    }

    public function pushData($row)
    {
        $this->data[] = $row;
    }

    public function getData()
    {
        return $this->data;
    }
}

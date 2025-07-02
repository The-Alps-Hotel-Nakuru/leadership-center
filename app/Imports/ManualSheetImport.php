<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ManualSheetImport implements ToCollection
{
    protected $sheetTitle;
    protected $parent;

    public function __construct($sheetTitle, $parent)
    {
        $this->sheetTitle = $sheetTitle;
        $this->parent = $parent;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $index => $row) {
            $data = $row->toArray();
            if ($index === 0) {
                $data[] = 'ATTENDANCE DATE';
            }else {
                $data[] = Carbon::parse($this->sheetTitle)->format('Y-m-d');
            }
            $this->parent->pushData($data);
        }
    }
}

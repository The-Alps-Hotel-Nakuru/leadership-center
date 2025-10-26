<?php

namespace App\Exports\ForceHRMS;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class Company implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Company';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'company_name',
            'email',
            'phone',
            'address',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Get company info from .env configuration
        $name = config('app.company_name') ?? env('COMPANY_NAME');
        $email = config('app.company_email') ?? env('COMPANY_EMAIL');
        $phone = config('app.company_phone') ?? env('COMPANY_PHONE', '');
        $address = config('app.company_address') ?? env('COMPANY_ADDRESS', '');

        return collect([
            [
                $name ?? '',
                $email ?? '',
                $phone ?? '',
                $address ?? '',
            ],
        ]);
    }
}

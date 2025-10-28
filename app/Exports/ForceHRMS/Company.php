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
            'Name',
            'Address',
            'Phone',
            'Email',
            'Description',
            'Opening Date',
            'Bank Name',
            'Bank Account Number',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Get company info from .env configuration
        $name = config('app.company.name') ?? env('COMPANY_NAME');
        $email = config('app.company.email') ?? env('COMPANY_EMAIL');
        $phone = config('app.company.phone') ?? env('COMPANY_PHONE', '');
        $address = config('app.company.address') ?? env('COMPANY_ADDRESS', '');
        $description = config('app.company.description') ?? env('COMPANY_DESCRIPTION', '');
        $openingDate = config('app.company.opening_date') ?? env('COMPANY_OPENING_DATE', '');
        $bankName = env('BANK_NAME', '');
        $bankAccountNumber = env('BANK_ACCOUNT_NUMBER', '');

        return collect([
            [
                $name ?? '',
                $email ?? '',
                $phone ?? '',
                $address ?? '',
                $description ?? '',
                $openingDate ?? '',
                $bankName ?? '',
                $bankAccountNumber ?? '',
            ],
        ]);
    }
}

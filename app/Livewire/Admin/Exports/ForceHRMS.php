<?php

namespace App\Livewire\Admin\Exports;

use App\Exports\ForceHRMS\FullDataExportForceHRMS;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ForceHRMS extends Component
{
    public function getCompanyName()
    {
        return config('app.company.name', 'Company');
    }

    public function export()
    {
        try {
            // Create the exporter
            $exporter = new FullDataExportForceHRMS();

            // Generate filename with company name
            $timestamp = now()->format('YmdHis');
            $companySlug = str(config('app.company.name', 'company'))->slug();
            $filename = "force_hrm_{$companySlug}_{$timestamp}.xlsx";

            // Log success
            $this->dispatch('done', success: "Export generated successfully: {$filename}");

            // Download the file directly
            return Excel::download($exporter, $filename);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Force HRM Export Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('done', error: "Export failed: {$e->getMessage()}");
        }
    }

    public function render()
    {
        return view('livewire.admin.exports.force-hrms');
    }
}

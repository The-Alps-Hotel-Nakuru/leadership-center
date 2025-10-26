<?php

namespace App\Livewire\Admin\Exports;

use App\Exports\ForceHRMS\FullDataExportForceHRMS;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ForceHRMS extends Component
{
    public $exporting = false;
    public $exportMessage = '';
    public $exportSuccess = false;

    public function export()
    {
        $this->exporting = true;
        $this->exportMessage = 'Generating Force HRMS export...';

        try {
            // Create the exporter
            $exporter = new FullDataExportForceHRMS();

            // Generate filename
            $timestamp = now()->format('YmdHis');
            $filename = "force_hrms_export_{$timestamp}.xlsx";

            // Download the file directly
            return Excel::download($exporter, $filename);
        } catch (\Exception $e) {
            $this->exportMessage = "Export failed: {$e->getMessage()}";
            $this->exportSuccess = false;

            // Log the error
            \Log::error('Force HRMS Export Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('error', "Export failed: {$e->getMessage()}");
            $this->exporting = false;
        }
    }

    public function render()
    {
        return view('livewire.admin.exports.force-hrms');
    }
}

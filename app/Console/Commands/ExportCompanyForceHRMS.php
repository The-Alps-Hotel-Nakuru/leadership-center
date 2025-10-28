<?php

namespace App\Console\Commands;

use App\Exports\ForceHRMS\FullDataExportForceHRMS;
use App\Models\Company;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportCompanyForceHRMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:export-force-hrms';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Export company data in Force HRMS compatible format';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get company info from config
        $companyName = config('app.company.name') ?? env('COMPANY_NAME');
        if (!$companyName) {
            $this->error("No company configured. Please set COMPANY_NAME in .env");
            return 1;
        }

        // Try to get company ID from database, fallback to 1 for single-company deployment
        $company = Company::first();
        $companyId = $company?->id ?? 1;

        $this->info("Starting export for company: {$companyName}");

        try {
            // Create export instance
            $exporter = new FullDataExportForceHRMS();

            // Generate filename
            $timestamp = now()->format('YmdHis');
            $filename = "force_hrms_export_{$timestamp}.xlsx";

            // Export to storage
            $this->info("Generating Excel file...");
            $path = 'exports/' . $filename;
            Excel::store($exporter, $path);
            $this->info("Export completed successfully!");
            $this->info("File saved to: storage/app/{$path}");
            return 0;
        } catch (\Exception $e) {
            $this->error("Export failed: " . $e->getMessage());
            \Log::error('Force HRMS Export Error', [
                'company_id' => $companyId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return 1;
        }
    }
}

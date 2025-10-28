<div>
    <x-slot:header>Force HRM Export - {{ config('app.company.name', 'Company') }}</x-slot:header>

    <div class="row">
        <!-- Main Export Card -->
        <div class="col-lg-8 col-12">
            <div class="card card-primary card-outline">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="bi bi-download me-2"></i>Generate Force HRM Export for {{ config('app.company.name', 'Company') }}
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        Click the button below to generate an Excel file compatible with Force HRM import module. The file will be automatically downloaded to your computer.
                    </p>

                    <!-- Export Button -->
                    <div class="mb-4">
                        <button
                            wire:click="export"
                            wire:loading.attr="disabled"
                            class="btn btn-primary w-100"
                        >
                            <span wire:loading.remove wire:target="export">
                                <i class="bi bi-cloud-download me-2"></i>Generate & Download Export
                            </span>
                            <span wire:loading wire:target="export">
                                <i class="spinner-border spinner-border-sm me-2"></i>Generating Export...
                            </span>
                        </button>
                    </div>

                    <!-- Data Structure Section -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold mb-3 text-primary">
                                <i class="bi bi-check-circle me-2"></i>Required Sheets
                            </h6>
                            <ul class="list-unstyled small">
                                <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Company Info</li>
                                <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Departments</li>
                                <li class="mb-2"><i class="bi bi-check text-success me-2"></i>Designations</li>
                                <li><i class="bi bi-check text-success me-2"></i>Employees</li>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <h6 class="font-weight-bold mb-3 text-info">
                                <i class="bi bi-plus-circle me-2"></i>Optional Sheets
                            </h6>
                            <ul class="list-unstyled small text-muted">
                                <li class="mb-2">Employment Types, Leave Types</li>
                                <li class="mb-2">Leaves & Contracts</li>
                                <li class="mb-2">Fines, Bonuses, Advances</li>
                                <li class="mb-2">Attendances & Extra Works</li>
                                <li>Payrolls & Payments</li>
                            </ul>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Format Standards -->
                    <h6 class="font-weight-bold mb-3">
                        <i class="bi bi-table me-2"></i>Data Format Standards
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="small mb-3">
                                <i class="bi bi-calendar3 text-primary me-2"></i>
                                <strong>Dates:</strong> YYYY-MM-DD (e.g., 2024-01-15)
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small mb-3">
                                <i class="bi bi-clock-history text-primary me-2"></i>
                                <strong>Times:</strong> HH:MM:SS (e.g., 09:30:00)
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small mb-3">
                                <i class="bi bi-at text-primary me-2"></i>
                                <strong>Employee ID:</strong> Email address (primary key)
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small mb-3">
                                <i class="bi bi-filetype-xlsx text-primary me-2"></i>
                                <strong>File Format:</strong> Excel (.xlsx)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info & Steps Sidebar -->
        <div class="col-lg-4 col-12">
            <!-- Quick Steps Card -->
            <div class="card card-info card-outline mb-3">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="bi bi-list-check me-2"></i>Quick Steps
                    </h3>
                </div>
                <div class="card-body">
                    <ol class="mb-0 small">
                        <li class="mb-2">Click the export button</li>
                        <li class="mb-2">File downloads automatically</li>
                        <li class="mb-2">Login to Force HRMS</li>
                        <li class="mb-2">Go to Settings → Import Data</li>
                        <li class="mb-2">Upload the Excel file</li>
                        <li>Verify and complete import</li>
                    </ol>
                </div>
            </div>

            <!-- About Card -->
            <div class="card card-success card-outline">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="bi bi-info-circle me-2"></i>About This Export
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="d-block font-weight-bold mb-1">File Size</small>
                        <small class="text-muted">500KB - 2MB depending on data volume</small>
                    </div>
                    <div class="mb-3">
                        <small class="d-block font-weight-bold mb-1">Naming Convention</small>
                        <small class="text-muted">force_hrm_{{ str(config('app.company.name', 'company'))->slug() }}_[timestamp].xlsx</small>
                    </div>
                    <div class="mb-3">
                        <small class="d-block font-weight-bold mb-1">Storage</small>
                        <small class="text-success">
                            <i class="bi bi-check-circle me-1"></i>Zero server storage
                        </small>
                    </div>
                    <div class="alert alert-success py-2 px-3 mb-0 small">
                        <i class="bi bi-lightning-fill me-2"></i>
                        <strong>Fast & Secure</strong> - Direct download
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

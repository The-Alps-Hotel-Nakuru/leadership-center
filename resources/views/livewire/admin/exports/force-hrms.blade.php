<div>
    <x-slot:header>Force HRMS Export</x-slot:header>

    <div class="row">
        <div class="col-lg-8 col-12">
            <div class="card card-primary card-outline">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="bi bi-download mr-3"></i>Generate Force HRMS Export
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        Click the button below to generate an Excel file compatible with Force HRMS import module. The file will be automatically downloaded to your computer.
                    </p>

                    <div class="mb-4">
                        <button
                            wire:click="export"
                            wire:loading.attr="disabled"
                            {{ $exporting ? 'disabled' : '' }}
                            class="btn btn-lg btn-primary btn-block"
                        >
                            <span wire:loading.remove wire:target="export">
                                <i class="bi bi-cloud-download mr-3"></i>Generate & Download Export
                            </span>
                            <span wire:loading wire:target="export">
                                <i class="spinner-border spinner-border-sm mr-3"></i>Generating Export...
                            </span>
                        </button>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            <strong>Error:</strong> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($exportMessage)
                        <div class="alert {{ $exportSuccess ? 'alert-success' : 'alert-danger' }} alert-dismissible fade show mb-3" role="alert">
                            <i class="bi {{ $exportSuccess ? 'bi-check-circle' : 'bi-exclamation-triangle' }} mr-2"></i>
                            {{ $exportMessage }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4 pb-3 border-right">
                                <h6 class="font-weight-bold mb-3 text-primary">
                                    <i class="bi bi-file-excel mr-3"></i>Required Sheets
                                </h6>
                                <div class="list-group list-group-sm">
                                    <div class="list-group-item px-0 py-2 border-0">
                                        <i class="bi bi-check text-success mr-3"></i>
                                        <span>Company Info</span>
                                    </div>
                                    <div class="list-group-item px-0 py-2 border-0">
                                        <i class="bi bi-check text-success mr-3"></i>
                                        <span>Departments</span>
                                    </div>
                                    <div class="list-group-item px-0 py-2 border-0">
                                        <i class="bi bi-check text-success mr-3"></i>
                                        <span>Designations</span>
                                    </div>
                                    <div class="list-group-item px-0 py-2 border-0">
                                        <i class="bi bi-check text-success mr-3"></i>
                                        <span>Employees</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4 pb-3">
                                <h6 class="font-weight-bold mb-3 text-info">
                                    <i class="bi bi-file-earmark-spreadsheet mr-3"></i>Optional Sheets
                                </h6>
                                <div class="list-group list-group-sm">
                                    <div class="list-group-item px-0 py-2 border-0">
                                        <i class="bi bi-plus-circle text-info mr-3"></i>
                                        <span class="text-muted">Employment Types, Leave Types</span>
                                    </div>
                                    <div class="list-group-item px-0 py-2 border-0">
                                        <i class="bi bi-plus-circle text-info mr-3"></i>
                                        <span class="text-muted">Leaves & Contracts</span>
                                    </div>
                                    <div class="list-group-item px-0 py-2 border-0">
                                        <i class="bi bi-plus-circle text-info mr-3"></i>
                                        <span class="text-muted">Fines, Bonuses, Advances</span>
                                    </div>
                                    <div class="list-group-item px-0 py-2 border-0">
                                        <i class="bi bi-plus-circle text-info mr-3"></i>
                                        <span class="text-muted">Attendances & Extra Works</span>
                                    </div>
                                    <div class="list-group-item px-0 py-2 border-0">
                                        <i class="bi bi-plus-circle text-info mr-3"></i>
                                        <span class="text-muted">Payrolls & Payments</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div>
                        <h6 class="font-weight-bold mb-3 text-muted">
                            <i class="bi bi-table mr-3"></i>Data Format Standards
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex mb-2">
                                    <i class="bi bi-calendar3 text-primary mr-3 mt-1"></i>
                                    <div>
                                        <small class="d-block font-weight-bold">Dates</small>
                                        <small class="text-muted">YYYY-MM-DD (e.g., 2024-01-15)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex mb-2">
                                    <i class="bi bi-clock-history text-primary mr-3 mt-1"></i>
                                    <div>
                                        <small class="d-block font-weight-bold">Times</small>
                                        <small class="text-muted">HH:MM:SS (e.g., 09:30:00)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex mb-2">
                                    <i class="bi bi-at text-primary mr-3 mt-1"></i>
                                    <div>
                                        <small class="d-block font-weight-bold">Employee ID</small>
                                        <small class="text-muted">Email address (primary key)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex mb-2">
                                    <i class="bi bi-filetype-xlsx text-primary mr-3 mt-1"></i>
                                    <div>
                                        <small class="d-block font-weight-bold">File Format</small>
                                        <small class="text-muted">Excel (.xlsx)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <!-- Quick Steps Card -->
            <div class="card card-outline card-info mb-3">
                <div class="card-header border-0 bg-info">
                    <h3 class="card-title text-white">
                        <i class="bi bi-list-check mr-3"></i>Quick Steps
                    </h3>
                </div>
                <div class="card-body">
                    <ol class="mb-0">
                        <li class="mb-2">
                            <span class="font-weight-bold">Click Button</span>
                            <small class="d-block text-muted">Click the export button on the left</small>
                        </li>
                        <li class="mb-2">
                            <span class="font-weight-bold">Download</span>
                            <small class="d-block text-muted">File downloads automatically to your device</small>
                        </li>
                        <li class="mb-2">
                            <span class="font-weight-bold">Login to Force HRMS</span>
                            <small class="d-block text-muted">Access your Force HRMS account</small>
                        </li>
                        <li class="mb-2">
                            <span class="font-weight-bold">Go to Import</span>
                            <small class="d-block text-muted">Settings → Import Data</small>
                        </li>
                        <li class="mb-2">
                            <span class="font-weight-bold">Upload File</span>
                            <small class="d-block text-muted">Select and upload the Excel file</small>
                        </li>
                        <li>
                            <span class="font-weight-bold">Complete Import</span>
                            <small class="d-block text-muted">Verify and finish the process</small>
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card card-outline card-success">
                <div class="card-header border-0 bg-success">
                    <h3 class="card-title text-white">
                        <i class="bi bi-info-circle mr-3"></i>About This Export
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="d-block text-muted mb-1">
                            <strong>File Size</strong>
                        </small>
                        <small>Typically 500KB - 2MB depending on data volume</small>
                    </div>
                    <div class="mb-3">
                        <small class="d-block text-muted mb-1">
                            <strong>Naming Convention</strong>
                        </small>
                        <small>force_hrms_export_[timestamp].xlsx</small>
                    </div>
                    <div class="mb-3">
                        <small class="d-block text-muted mb-1">
                            <strong>Storage</strong>
                        </small>
                        <small class="text-success">
                            <i class="bi bi-check-circle mr-2"></i>Zero server storage - generated on-demand
                        </small>
                    </div>
                    <div class="alert alert-success py-2 px-3 mb-0">
                        <small class="d-block">
                            <i class="bi bi-lightning-fill mr-3"></i>
                            <strong>Fast & Secure</strong> - Direct download, no temporary files
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

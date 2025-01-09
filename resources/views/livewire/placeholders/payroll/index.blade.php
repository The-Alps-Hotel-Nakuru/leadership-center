<div wire:init='loadItems'>
    <x-slot name="header">
        Payrolls
    </x-slot>
    <div class="container-fluid my-3">
        <div class="card">
            <div class="card-header">
                <h5 class="placeholder-wave">Generate Payroll</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="" class="form-label">Year</label>
                            <input wire:model.live="yearmonth" type="month" class="form-control" name=""
                                id="" aria-describedby="helpId" placeholder="Choose the Year">
                        </div>
                    </div>
                    <button class="btn btn-primary disabled" wire:loading.attr="disabled" wire:target="generate"
                        wire:click="generate">
                        <span class="placeholder placeholder-xl"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" wire:loading.class='disabled'>
        <div class="card">
            <div class="card-header">
                <h5>List of Generated Payrolls</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table
                table-hover
                align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Period</th>
                            <th>This Payroll Total</th>
                            <th>Total PAYE</th>
                            <th>Total NSSF</th>
                            <th>Total NHIF</th>
                            <th>Total SHIF</th>
                            <th>Total NITA</th>
                            <th>Total Housing Levy</th>
                            <th>Total Advances</th>
                            <th>Total Overtimes</th>
                            <th>Total Bonuses</th>
                            <th>Total Fines</th>
                            <th>Total Loans</th>
                            <th>Staff Welfare Contributions</th>
                            <th>Total NET PAY</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                        @for ($i = 0; $i < 5; $i++)
                            <tr class="">
                                <td class="placeholder-wave" scope="row">
                                    <span class="placeholder placeholder-lg col-12"></span>
                                </td>
                                <td class="placeholder-wave">
                                    <span class="placeholder placeholder-lg col-12"></span>
                                    <span class="placeholder placeholder-lg col-6"></span>
                                </td>
                                <td>
                                    <span class="placeholder placeholder-lg col-6"></span>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                </td>
                                <td>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                </td>
                                <td>
                                    <span class="placeholder placeholder-lg col-6"></span>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                </td>
                                <td>
                                    <span class="placeholder placeholder-lg col-6"></span>
                                    <span class="placeholder placeholder-lg col-6"></span>
                                </td>
                                <td>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                </td>
                                <td>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                </td>
                                <td>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                </td>
                                <td>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                </td>
                                <td>
                                    <span class="placeholder placeholder-lg col-8"></span>
                                    <span class="placeholder placeholder-lg col-4"></span>
                                </td>
                                <td>
                                    <span class="placeholder placeholder-lg col-8"></span>
                                    <span class="placeholder placeholder-lg col-4"></span>
                                </td>
                                <td>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                </td>
                                <td>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                </td>
                                <td>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                    <span class="placeholder placeholder-lg col-12"></span>
                                </td>
                                <td class="bg-dark text-white">
                                    <span class="placeholder placeholder-lg bg-white col-12"></span>
                                    <span class="placeholder placeholder-lg bg-success col-12"></span>
                                </td>
                                <td class="d-flex flex-row">
                                    <div class="flex-col m-3">
                                        <button class="btn btn-secondary">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </button>
                                    </div>
                                    <div class="flex-col m-3 ">
                                        <button class="btn btn-secondary">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </button>
                                    </div>
                                    <div class="flex-col m-3">
                                        <button class="btn btn-primary">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </button>
                                    </div>
                                    <div class="flex-col m-3">
                                        <button class="btn btn-success">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </button>
                                    </div>
                                    <div class="flex-col m-3">
                                        <button class="btn btn-secondary">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </button>
                                    </div>
                                    <div class="flex-col m-3">
                                        <button class="btn btn-primary">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </button>
                                    </div>
                                    <div class="flex-col m-3">
                                        <button class="btn btn-danger">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>

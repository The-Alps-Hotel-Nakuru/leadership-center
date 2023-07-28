<?php

use App\Http\Livewire\Admin;
use App\Http\Livewire\Employee;
use App\Models\EmployeeContract;
use App\Models\MonthlySalary;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/dashboard');

// if (auth()->user()->is_admin) {
//     Route::redirect('/dashboard','/admin/dashboard');
// }
// else if (auth()->user()->is_employee) {
//     Route::redirect('/dashboard','/employee/dashboard');
// }

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('dashboard', function () {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->is_employee) {
            return redirect()->route('employee.dashboard');
        } else {
            abort(403, 'You don\'t have a role here');
        }
    });


    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('dashboard', Admin\Dashboard::class)->name('admin.dashboard');

        Route::prefix('admins')->group(function () {
            Route::get('/', Admin\Admins\Index::class)->name('admin.admins.index');
            Route::get('/create', Admin\Admins\Create::class)->name('admin.admins.create');
            Route::get('/{id}/edit', Admin\Admins\Edit::class)->name('admin.admins.edit');
        });
        Route::prefix('departments')->group(function () {
            Route::get('/', Admin\Departments\Index::class)->name('admin.departments.index');
            Route::get('/create', Admin\Departments\Create::class)->name('admin.departments.create');
            Route::get('/{id}/edit', Admin\Departments\Edit::class)->name('admin.departments.edit');
        });
        Route::prefix('designations')->group(function () {
            Route::get('/', Admin\Designations\Index::class)->name('admin.designations.index');
            Route::get('/create', Admin\Designations\Create::class)->name('admin.designations.create');
            Route::get('/{id}/edit', Admin\Designations\Edit::class)->name('admin.designations.edit');
        });
        Route::prefix('advances')->group(function () {
            Route::get('/', Admin\Advances\Index::class)->name('admin.advances.index');
            Route::get('/create', Admin\Advances\Create::class)->name('admin.advances.create');
            Route::get('/{id}/edit', Admin\Advances\Edit::class)->name('admin.advances.edit');
        });
        Route::prefix('fines')->group(function () {
            Route::get('/', Admin\Fines\Index::class)->name('admin.fines.index');
            Route::get('/create', Admin\Fines\Create::class)->name('admin.fines.create');
            Route::get('/{id}/edit', Admin\Fines\Edit::class)->name('admin.fines.edit');
        });
        Route::prefix('bonuses')->group(function () {
            Route::get('/', Admin\Bonuses\Index::class)->name('admin.bonuses.index');
            Route::get('/create', Admin\Bonuses\Create::class)->name('admin.bonuses.create');
            Route::get('/{id}/edit', Admin\Bonuses\Edit::class)->name('admin.bonuses.edit');
        });
        Route::prefix('employees')->group(function () {
            Route::get('/', Admin\Employees\Index::class)->name('admin.employees.index');
            Route::get('/{id}/profile', Admin\Employees\Show::class)->name('admin.employees.show');
            Route::get('/create', Admin\Employees\Create::class)->name('admin.employees.create');
            Route::get('/{id}/edit', Admin\Employees\Edit::class)->name('admin.employees.edit');
        });
        Route::prefix('employee_contracts')->group(function () {
            Route::get('/', Admin\EmployeeContracts\Index::class)->name('admin.employee_contracts.index');
            Route::get('/{id}/contract', Admin\EmployeeContracts\Show::class)->name('admin.employee_contracts.show');
            Route::get('/create', Admin\EmployeeContracts\Create::class)->name('admin.employee_contracts.create');
            Route::get('/{id}/edit', Admin\EmployeeContracts\Edit::class)->name('admin.employee_contracts.edit');
        });

        Route::prefix('attendances')->group(function () {
            Route::get('/', Admin\Attendances\Index::class)->name('admin.attendances.index');
            Route::get('/create', Admin\Attendances\Create::class)->name('admin.attendances.create');
            Route::get('/{id}/edit', Admin\Attendances\Edit::class)->name('admin.attendances.edit');
            Route::get('/mass_addition', Admin\Attendances\MassAddition::class)->name('admin.attendances.mass_addition');
        });
        Route::prefix('product_categories')->group(function () {
            Route::get('/', Admin\ProductCategories\Index::class)->name('admin.product_categories.index');
            Route::get('/create', Admin\ProductCategories\Create::class)->name('admin.product_categories.create');
            Route::get('/{id}/edit', Admin\ProductCategories\Edit::class)->name('admin.product_categories.edit');
        });
        Route::prefix('responsibilities')->group(function () {
            Route::get('/', Admin\Responsibilities\Index::class)->name('admin.responsibilities.index');
            Route::get('/{designation_id}/create', Admin\Responsibilities\Create::class)->name('admin.responsibilities.create');
            Route::get('/{id}/edit', Admin\Responsibilities\Edit::class)->name('admin.responsibilities.edit');
        });
        Route::prefix('payrolls')->group(function () {
            Route::get('/', Admin\Payrolls\Index::class)->name('admin.payrolls.index');
            Route::get('/{id}/show', Admin\Payrolls\Show::class)->name('admin.payrolls.show');
        });
        // Route::prefix('products')->group(function () {
        //     Route::get('/', Admin\Products\Index::class)->name('admin.products.index');
        //     Route::get('/create', Admin\Products\Create::class)->name('admin.products.create');
        //     Route::get('/{id}/edit', Admin\Products\Edit::class)->name('admin.products.edit');
        // });
        // Route::prefix('asset_categories')->group(function () {
        //     Route::get('/', Admin\AssetCategories\Index::class)->name('admin.asset_categories.index');
        //     Route::get('/create', Admin\AssetCategories\Create::class)->name('admin.asset_categories.create');
        //     Route::get('/{id}/edit', Admin\AssetCategories\Edit::class)->name('admin.asset_categories.edit');
        // });
        // Route::prefix('asset_subcategories')->group(function () {
        //     Route::get('/', function () {
        //         return redirect()->route('admin.asset_categories.index');
        //     })->name('admin.asset_subcategories.index');
        //     Route::get('/create', Admin\AssetSubcategories\Create::class)->name('admin.asset_subcategories.create');
        //     Route::get('/{id}/edit', Admin\AssetSubcategories\Edit::class)->name('admin.asset_subcategories.edit');
        // });
        // Route::prefix('assets')->group(function () {
        //     Route::get('/', Admin\Assets\Index::class)->name('admin.assets.index');
        //     Route::get('/create', Admin\Assets\Create::class)->name('admin.assets.create');
        //     Route::get('/{id}/edit', Admin\Assets\Edit::class)->name('admin.assets.edit');
        // });
        // Route::prefix('conference-halls')->group(function () {
        //     Route::get('/', Admin\ConferenceHalls\Index::class)->name('admin.conference-halls.index');
        //     Route::get('/create', Admin\ConferenceHalls\Create::class)->name('admin.conference-halls.create');
        //     Route::get('/{id}/edit', Admin\ConferenceHalls\Edit::class)->name('admin.conference-halls.edit');
        // });
        // Route::prefix('event-orders')->group(function () {
        //     Route::get('/', Admin\EventOrders\Index::class)->name('admin.event-orders.index');
        //     Route::get('/create', Admin\EventOrders\Create::class)->name('admin.event-orders.create');
        //     Route::get('/{id}/edit', Admin\EventOrders\Edit::class)->name('admin.event-orders.edit');
        // });

        // Route::prefix('uniforms')->group(function () {
        //     Route::get('/', Admin\Uniforms\Index::class)->name('admin.uniforms.index');
        //     Route::get('/create', Admin\Uniforms\Create::class)->name('admin.uniforms.create');
        //     Route::get('/{id}/edit', Admin\Uniforms\Edit::class)->name('admin.uniforms.edit');
        // });
        // Route::prefix('uniform-items')->group(function () {
        //     Route::get('/', Admin\UniformItems\Index::class)->name('admin.uniform-items.index');
        //     Route::get('/create', Admin\UniformItems\Create::class)->name('admin.uniform-items.create');
        //     Route::get('/{id}/edit', Admin\UniformItems\Edit::class)->name('admin.uniform-items.edit');
        // });
    });




    /**
     * Employees' Links
     */
    Route::middleware('employee')->prefix('employee')->group(function () {
        Route::get('dashboard', Employee\Dashboard::class)->name('employee.dashboard');

        Route::get('payslips', Employee\Payslips::class)->name('employee.payslips');
        Route::get('/{id}/payslips', function ($id) {

            $salary = MonthlySalary::find($id);



            if (auth()->user()->employee->id == $salary->employees_detail_id) {
                $pdf = Pdf::setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isHTML5ParserEnabled' => true, 'debugPng' => true])->setPaper('a4', 'portrait');

                $pdf->loadView('doc.payslip', [
                    'salary' => $salary
                ]);
                return $pdf->stream();
            } else {
                abort(403, "You Are Not Authorized to view this Payslip because it doesn't belong to you");
            }
        })->name('employee.payslips.view');
    });
});



Route::get('testPDF', function () {

    $faker = Factory::create();

    $pdf = Pdf::loadView('test_pdf', [
        'title' => 'Test PDF',
        'document' => 'Contract',
        'doc_no' => '1',
        'date' => Carbon::now()->toDateString(),
        'client_name' => 'Steve Nyanumba',
        'client_phone' => '+254712345678',
        'client_address' => $faker->address,
        'client_city' => $faker->city,
        'client_country' => $faker->country,
        'amount' => rand(3, 50) * 1000,
        'bo'
    ]);

    return $pdf->stream();
});
Route::get('/{id}/draft_contract', function ($id) {

    $faker = Factory::create();

    $pdf = Pdf::loadView('doc.contract', [
        'contract' => EmployeeContract::find($id)
    ])->setOptions(['defaultFont' => 'sans-serif']);

    return $pdf->stream();
})->name('doc.contract');
Route::get('/{id}/payslip', function ($id) {
    $pdf = Pdf::setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isHTML5ParserEnabled' => true, 'debugPng' => true])->setPaper('a4', 'portrait');

    $pdf->loadView('doc.payslip', [
        'salary' => MonthlySalary::find($id)
    ]);
    return $pdf->stream();
})->name('doc.payslip');


Route::get('/event-summary-today', function () {

    $pdf = Pdf::loadView('doc.summary', [
        'date' => Carbon::now()->today()->toDateString()
    ])->setOptions(['defaultFont' => 'sans-serif']);

    return $pdf->stream();
})->name('today-event-summary');



Route::get('/casuals-contract', function () {

    $pdf = Pdf::loadView('doc.casual')->setOptions(['DOMPDF_ENABLE_REMOTE' => true]);
    return $pdf->stream();
});


// Test URLs

// Route::get('/')

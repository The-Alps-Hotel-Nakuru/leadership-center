<?php

use App\Http\Livewire\Admin;
use App\Http\Livewire\Employee;
use App\Models\EmployeeContract;
use App\Models\Log;
use App\Models\MonthlySalary;
use App\Models\Payroll;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\Route;
use LynX39\LaraPdfMerger\Facades\PdfMerger;

use function Deployer\download;

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

//first commit
//second commit

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
            if (auth()->user()->first_login) {
                $user = User::find(auth()->user()->id);
                $user->first_login = false;
                $user->save();
                return redirect()->route('employee.profile');
            } else {
                return redirect()->route('employee.dashboard');
            }
        } else {
            abort(403, 'You don\'t have a role here');
        }
    });


    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('dashboard', Admin\Dashboard::class)->name('admin.dashboard');

        Route::prefix('settings')->group(function () {
            Route::get('/mail', Admin\Settings\Mail::class)->name('admin.settings.mail');
            Route::get('/general', Admin\Settings\General::class)->name('admin.settings.general');
        });
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
            Route::get('/mass_addition', Admin\Fines\MassAddition::class)->name('admin.employee_fines.mass_addition');
        });
        Route::prefix('bonuses')->group(function () {
            Route::get('/', Admin\Bonuses\Index::class)->name('admin.bonuses.index');
            Route::get('/create', Admin\Bonuses\Create::class)->name('admin.bonuses.create');
            Route::get('/{id}/edit', Admin\Bonuses\Edit::class)->name('admin.bonuses.edit');
            Route::get('/mass_addition', Admin\Bonuses\MassAddition::class)->name('admin.employee_bonuses.mass_addition');
        });
        Route::prefix('employees')->group(function () {
            Route::get('/', Admin\Employees\Index::class)->name('admin.employees.index');
            Route::get('/{id}/profile', Admin\Employees\Show::class)->name('admin.employees.show');
            Route::get('/create', Admin\Employees\Create::class)->name('admin.employees.create');
            Route::get('/{id}/edit', Admin\Employees\Edit::class)->name('admin.employees.edit');
            Route::get('/mass_addition', Admin\Employees\MassAddition::class)->name('admin.employees.mass_addition');
        });
        Route::prefix('banks')->group(function () {
            Route::get('/', Admin\Banks\Index::class)->name('admin.banks.index');
            Route::get('/create', Admin\Banks\Create::class)->name('admin.banks.create');
            Route::get('/{id}/edit', Admin\Banks\Edit::class)->name('admin.banks.edit');
            Route::get('/mass_addition', Admin\Banks\MassAddition::class)->name('admin.banks.mass_addition');
        });
        Route::prefix('employee_contracts')->group(function () {
            Route::get('/', Admin\EmployeeContracts\Index::class)->name('admin.employee_contracts.index');
            Route::get('/{id}/contract', Admin\EmployeeContracts\Show::class)->name('admin.employee_contracts.show');
            Route::get('/create', Admin\EmployeeContracts\Create::class)->name('admin.employee_contracts.create');
            Route::get('/{id}/edit', Admin\EmployeeContracts\Edit::class)->name('admin.employee_contracts.edit');
            Route::get('/mass_addition', Admin\EmployeeContracts\MassAddition::class)->name('admin.employee_contracts.mass_addition');
        });
        Route::prefix('employee_accounts')->group(function () {
            Route::get('/', Admin\EmployeeAccounts\Index::class)->name('admin.employee_accounts.index');
            Route::get('/create', Admin\EmployeeAccounts\Create::class)->name('admin.employee_accounts.create');
            Route::get('/{id}/edit', Admin\EmployeeAccounts\Edit::class)->name('admin.employee_accounts.edit');
            Route::get('/mass_addition', Admin\EmployeeAccounts\MassAddition::class)->name('admin.employee_accounts.mass_addition');
        });

        Route::prefix('attendances')->group(function () {
            Route::get('/', Admin\Attendances\Index::class)->name('admin.attendances.index');
            Route::get('/create', Admin\Attendances\Create::class)->name('admin.attendances.create');
            Route::get('/{id}/edit', Admin\Attendances\Edit::class)->name('admin.attendances.edit');
            Route::get('/mass_addition', Admin\Attendances\MassAddition::class)->name('admin.attendances.mass_addition');
        });
        Route::prefix('leaves')->group(function () {
            Route::get('/', Admin\Leaves\Index::class)->name('admin.leaves.index');
            Route::get('/create', Admin\Leaves\Create::class)->name('admin.leaves.create');
            Route::get('/{id}/edit', Admin\Leaves\Edit::class)->name('admin.leaves.edit');
            Route::get('/mass_addition', Admin\Leaves\MassAddition::class)->name('admin.leaves.mass_addition');
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
        Route::prefix('welfare_contributions')->group(function () {
            Route::get('/', Admin\WelfareContributions\Index::class)->name('admin.welfare_contributions.index');
            Route::get('/create', Admin\WelfareContributions\Create::class)->name('admin.welfare_contributions.create');
            Route::get('/{id}/edit', Admin\WelfareContributions\Edit::class)->name('admin.welfare_contributions.edit');
            Route::get('/mass_addition', Admin\WelfareContributions\MassAddition::class)->name('admin.welfare_contributions.mass_addition');
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
        Route::prefix('asset_categories')->group(function () {
            Route::get('/', Admin\AssetCategories\Index::class)->name('admin.asset_categories.index');
            Route::get('/create', Admin\AssetCategories\Create::class)->name('admin.asset_categories.create');
            Route::get('/{id}/edit', Admin\AssetCategories\Edit::class)->name('admin.asset_categories.edit');
        });
        Route::prefix('asset_subcategories')->group(function () {
            Route::get('/', Admin\AssetSubcategories\Index::class)->name('admin.asset_subcategories.index');
            Route::get('/create', Admin\AssetSubcategories\Create::class)->name('admin.asset_subcategories.create');
            Route::get('/{id}/edit', Admin\AssetSubcategories\Edit::class)->name('admin.asset_subcategories.edit');
        });
        Route::prefix('assets')->group(function () {
            Route::get('/', Admin\Assets\Index::class)->name('admin.assets.index');
            Route::get('/create', Admin\Assets\Create::class)->name('admin.assets.create');
            Route::get('/{id}/edit', Admin\Assets\Edit::class)->name('admin.assets.edit');
        });
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
        Route::get('profile', Employee\Profile::class)->name('employee.profile');

        Route::get('payslips', Employee\Payslips::class)->name('employee.payslips');
        Route::get('/{id}/payslips', function ($id) {

            $salary = MonthlySalary::find($id);



            if (auth()->user()->employee->id == $salary->employees_detail_id) {
                if ($salary->payroll->payment) {
                    $pdf = Pdf::setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isHTML5ParserEnabled' => true, 'debugPng' => true])->setPaper(array(0, 0, 400, 1200), 'portrait');

                    $pdf->loadView('doc.payslip', [
                        'salary' => $salary
                    ]);
                    return $pdf->stream();
                } else {
                    Log::create([
                        'user_id' => auth()->user()->id,
                        'payload' => "tried to view the Payslip when not Ready",
                        'model' => 'App\Models\Payroll'
                    ]);
                    abort(403, "You Are Not Authorized to view this Payslip because it is not ready");
                }
            } else {
                Log::create([
                    'user_id' => auth()->user()->id,
                    'payload' => "tried to view someone else's payslip",
                    'model' => 'App\Models\Payroll'
                ]);
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
    $pdf = Pdf::setPaper(array(0, 0, 400, 1200), 'portrait')->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isHTML5ParserEnabled' => false, 'debugPng' => true]);

    $pdf->loadView('doc.payslip', [
        'salary' => MonthlySalary::find($id)
    ]);
    return $pdf->stream();
})->name('doc.payslip');

function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object))
                    rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                else
                    unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }
        rmdir($dir);
    }
}
// Route::get('/{id}/print_payslips', function ($id) {

//     $payroll = Payroll::find($id);
//     $pdfMerger = PdfMerger::init();
//     foreach ($payroll->monthlySalaries as $key => $salary) {

//         $pdf = Pdf::setPaper(array(0, 0, 400, 1250), 'portrait')->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isHTML5ParserEnabled' => false, 'debugPng' => true]);
//         $pdf->loadView('doc.payslip', [
//             'salary' => $salary
//         ]);
//         $pdf->save('payslips/' . $salary->month_string . '/' . $key+1 . '.pdf', 'public');
//         $pdfMerger->addPDF('payslips/' . $salary->month_string . '/' . $key . '.pdf');
//     }
//     $pdfMerger->merge();
//     $pdfMerger->save(public_path(Carbon::parse($payroll->year . '-' . $payroll->month)->format('F-Y') . '.pdf'));
//     // rrmdir(public_path('payslips'));
//     Pdf::loadView('merged-payslips/' . Carbon::parse($payroll->year . '-' . $payroll->month)->format('F-Y') . '.pdf');
//     return $pdf->stream();
// })->name('doc.print-payslips');



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

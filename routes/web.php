<?php

use App\Livewire\Admin;
use App\Livewire\Employee;
use App\Livewire\Security;
use App\Models\EmployeeContract;
use App\Models\Log;
use App\Models\MonthlySalary;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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
Route::get('/test-contract-earnings', function () {
    $dd = [];

    foreach (EmployeeContract::all() as $key => $contract) {
        array_push($dd, $contract->employee->user->name . " earned: KES " . $contract->EarnedSalaryKes('2024-08') . " across " . $contract->netDaysWorked('2024-08') . " days");
    }

    dd($dd);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('dashboard', function () {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->is_security_guard) {
            return redirect()->route('security.dashboard');
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
        Route::prefix('security_guards')->group(function () {
            Route::get('/', Admin\SecurityGuards\Index::class)->name('admin.security_guards.index');
            Route::get('/create', Admin\SecurityGuards\Create::class)->name('admin.security_guards.create');
            Route::get('/{id}/edit', Admin\SecurityGuards\Edit::class)->name('admin.security_guards.edit');
        });
        Route::prefix('bans')->group(function () {
            Route::get('/', Admin\Bans\Index::class)->name('admin.bans.index');
        });
        Route::prefix('departments')->group(function () {
            Route::get('/', Admin\Departments\Index::class)->name('admin.departments.index');
            Route::get('/create', Admin\Departments\Create::class)->name('admin.departments.create');
            Route::get('/{id}/edit', Admin\Departments\Edit::class)->name('admin.departments.edit');
        });
        Route::prefix('holidays')->group(function () {
            Route::get('/', Admin\Holidays\Index::class)->name('admin.holidays.index');
            Route::get('/create', Admin\Holidays\Create::class)->name('admin.holidays.create');
            Route::get('/{id}/edit', Admin\Holidays\Edit::class)->name('admin.holidays.edit');
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
            Route::get('/mass_addition', Admin\Fines\MassAddition::class)->name('admin.fines.mass_addition');
        });
        Route::prefix('loans')->group(function () {
            Route::get('/', Admin\Loans\Index::class)->name('admin.loans.index');
            Route::get('/create', Admin\Loans\Create::class)->name('admin.loans.create');
            Route::get('/{id}/edit', Admin\Loans\Edit::class)->name('admin.loans.edit');
            Route::get('/{id}/show', Admin\Loans\Show::class)->name('admin.loans.show');
        });

        Route::prefix('loan_deductions')->group(function () {
            Route::get('/{loan_id}/create', Admin\LoanDeductions\Create::class)->name('admin.loan_deductions.create');
            Route::get('/{loan_id}/{id}/edit', Admin\LoanDeductions\Edit::class)->name('admin.loan_deductions.edit');
        });

        Route::prefix('bonuses')->group(function () {
            Route::get('/', Admin\Bonuses\Index::class)->name('admin.bonuses.index');
            Route::get('/create', Admin\Bonuses\Create::class)->name('admin.bonuses.create');
            Route::get('/{id}/edit', Admin\Bonuses\Edit::class)->name('admin.bonuses.edit');
            Route::get('/mass_addition', Admin\Bonuses\MassAddition::class)->name('admin.bonuses.mass_addition');
        });
        Route::prefix('employees')->group(function () {
            Route::get('/', Admin\Employees\Index::class)->name('admin.employees.index');
            Route::get('/{id}/profile', Admin\Employees\Show::class)->name('admin.employees.show');
            Route::get('/{id}/mark-exit', Admin\Employees\MarkExit::class)->name('admin.employees.mark-exit');
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
        Route::prefix('employment_types')->group(function () {
            Route::get('/', Admin\EmploymentTypes\Index::class)->name('admin.employment-types.index');
            Route::get('/create', Admin\EmploymentTypes\Create::class)->name('admin.employment-types.create');
            Route::get('/{id}/edit', Admin\EmploymentTypes\Edit::class)->name('admin.employment-types.edit');
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

        Route::prefix('biometrics')->group(function () {
            Route::get('/', Admin\Biometrics\Index::class)->name('admin.biometrics.index');
            Route::get('/create', Admin\Biometrics\Create::class)->name('admin.biometrics.create');
            Route::get('/{id}/edit', Admin\Biometrics\Edit::class)->name('admin.biometrics.edit');
            Route::get('/mass_addition', Admin\Biometrics\MassAddition::class)->name('admin.biometrics.mass_addition');
        });
        Route::prefix('attendances')->group(function () {
            Route::get('/', Admin\Attendances\Index::class)->name('admin.attendances.index');
            Route::get('/create', Admin\Attendances\Create::class)->name('admin.attendances.create');
            Route::get('/{id}/{instance}/edit', Admin\Attendances\Edit::class)->name('admin.attendances.edit');
            Route::get('/mass_addition', Admin\Attendances\MassAddition::class)->name('admin.attendances.mass_addition');
        });
        Route::prefix('extra-works')->group(function () {
            Route::get('/', Admin\ExtraWorks\Index::class)->name('admin.extra-works.index');
            Route::get('/create', Admin\ExtraWorks\Create::class)->name('admin.extra-works.create');
            Route::get('/{id}/{instance}/edit', Admin\ExtraWorks\Edit::class)->name('admin.extra-works.edit');
            Route::get('/mass_addition', Admin\ExtraWorks\MassAddition::class)->name('admin.extra-works.mass_addition');
        });
        Route::prefix('leave-types')->group(function () {
            Route::get('/', Admin\LeaveTypes\Index::class)->name('admin.leave-types.index');
            Route::get('/create', Admin\LeaveTypes\Create::class)->name('admin.leave-types.create');
            Route::get('/{id}/edit', Admin\LeaveTypes\Edit::class)->name('admin.leave-types.edit');
        });
        Route::prefix('leaves')->group(function () {
            Route::get('/', Admin\Leaves\Index::class)->name('admin.leaves.index');
            Route::get('/create', Admin\Leaves\Create::class)->name('admin.leaves.create');
            Route::get('/{id}/edit', Admin\Leaves\Edit::class)->name('admin.leaves.edit');
            Route::get('/mass_addition', Admin\Leaves\MassAddition::class)->name('admin.leaves.mass_addition');
        });
        Route::prefix('leave-requests')->group(function () {
            Route::get('/', Admin\LeaveRequests\Index::class)->name('admin.leave-requests.index');
            Route::get('/{id}/approve', Admin\LeaveRequests\Approve::class)->name('admin.leave-requests.approve');
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
        Route::prefix('holidays')->group(function () {
            Route::get('/', Admin\Holidays\Index::class)->name('admin.holidays.index');
            Route::get('/create', Admin\Holidays\Create::class)->name('admin.holidays.create');
            Route::get('/{id}/edit', Admin\Holidays\Edit::class)->name('admin.holidays.edit');
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
            Route::get('/{id}/upload_payment', Admin\Payrolls\UploadPayment::class)->name('admin.payrolls.upload_payment');
        });
        Route::prefix('payroll_payments')->group(function () {
            Route::get('/', Admin\PayrollPayments\Index::class)->name('admin.payroll_payments.index');
            Route::get('/{id}/show', Admin\PayrollPayments\Show::class)->name('admin.payroll_payments.show');
        });
    });




    /**
     * Employees' Links
     */
    Route::middleware('employee')->prefix('employee')->group(function () {
        Route::get('dashboard', Employee\Dashboard::class)->name('employee.dashboard');
        Route::get('profile', Employee\Profile::class)->name('employee.profile');
        Route::get('my-contracts', Employee\MyContracts::class)->name('employee.contracts');
        Route::get('my-leaves', Employee\MyLeaves::class)->name('employee.leaves');
        Route::get('p9-form-generator', Employee\P9Forms::class)->name('employee.p9forms');

        Route::prefix('advance-requests')->name('employee.advance-requests')->group(function () {
            Route::get('/', Employee\AdvanceRequests\Index::class)->name('.index');
            Route::get('/create', Employee\AdvanceRequests\Create::class)->name('.create');
            Route::get('/{id}/edit', Employee\AdvanceRequests\Edit::class)->name('.edit');
        });
        Route::prefix('leave-requests')->name('employee.leave-requests')->group(function () {
            Route::get('/', Employee\LeaveRequests\Index::class)->name('.index');
            Route::get('/create', Employee\LeaveRequests\Create::class)->name('.create');
            Route::get('/{id}/edit', Employee\LeaveRequests\Edit::class)->name('.edit');
        });
        Route::prefix('loan-requests')->name('employee.loan-requests')->group(function () {
            Route::get('/', Employee\LoanRequests\Index::class)->name('.index');
            Route::get('/create', Employee\LoanRequests\Create::class)->name('.create');
            Route::get('/{id}/edit', Employee\LoanRequests\Edit::class)->name('.edit');
        });

        Route::get('payslips', Employee\Payslips::class)->name('employee.payslips');
        Route::get('/{id}/payslips', function ($id) {
            $salary = MonthlySalary::where('payroll_id', $id)->where('employees_detail_id', auth()->user()->employee->id)->first();
            if ($salary->payroll->payments) {
                $pdf = Pdf::setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isHTML5ParserEnabled' => true, 'debugPng' => true])->setPaper(array(0, 0, 400, 1500), 'portrait');

                $pdf->loadView('doc.payslip', [
                    'salary' => $salary
                ]);
                Log::create([
                    'user_id' => auth()->user()->id,
                    'payload' => auth()->user()->name . "has Viewed their Payslip for " . $salary->getMonth()->format('F, Y'),
                    'model' => 'App\Models\Payroll'
                ]);
                return $pdf->stream();
            } else {
                Log::create([
                    'user_id' => auth()->user()->id,
                    'payload' => auth()->user()->name . "tried to view the Payslip when not Ready",
                    'model' => 'App\Models\Payroll'
                ]);
                abort(403, "You Are Not Authorized to view this Payslip because it is not ready");
            }
        })->name('employee.payslips.view');
    });




    /**
     * Security guards' Links
     */
    Route::middleware('security_guard')->prefix('security')->name('security.')->group(
        function () {
            Route::get('dashboard', Security\Dashboard::class)->name('dashboard');

            Route::prefix('users')->group(function () {
                Route::get('/', Security\Users\Index::class)->name('users.index');
                Route::get('/create', Security\Users\Create::class)->name('users.create');
            });

            Route::prefix('attendances')->group(function () {
                Route::get('/', Security\Attendance\Index::class)->name('attendances.index');
            });
        }
    );
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
Route::get('testp9', function () {
    $pdf = Pdf::setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isHTML5ParserEnabled' => true, 'debugPng' => true])->setPaper('a4', 'landscape');
    $pdf->loadView('doc.p9');
    return $pdf->stream();
});

Route::get('/{id}/draft_contract', function ($id) {
    $pdf = Pdf::loadView('doc.contract', [
        'contract' => EmployeeContract::find($id)
    ])->setOptions(['defaultFont' => 'sans-serif']);

    return $pdf->stream();
})->name('doc.contract');


Route::get('/p9form', function (Request $request) {
    $pdf = Pdf::setPaper('a4', 'landscape')->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isHTML5ParserEnabled' => false, 'debugPng' => true]);
    $pdf->loadView('doc.p9', ["p9Data" => $request->all()]);
    return $pdf->stream();
})->name('doc.p9');



Route::get('/{id}/payslip', function ($id) {
    $pdf = Pdf::setPaper(array(0, 0, 400, 1500), 'portrait')->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true, 'isHTML5ParserEnabled' => false, 'debugPng' => true]);
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


Route::get('/auto-update', function () {
    chdir(base_path());
    Artisan::call('migrate', ['--force' => true]);
    return 'Application has been updated and migrations have been run!';
});

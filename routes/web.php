<?php

use App\Http\Livewire\Admin;
use App\Http\Livewire\Employee;
use App\Models\Attendance;
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

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function(){

    Route::get('dashboard', function(){
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }elseif (auth()->user()->is_admin) {
            return redirect()->route('employee.dashboard');
        }
    });


    Route::middleware('admin')->prefix('admin')->group(function(){
        Route::get('dashboard', Admin\Dashboard::class)->name('admin.dashboard');

        Route::prefix('admins')->group(function(){
            Route::get('/', Admin\Admins\Index::class)->name('admin.admins.index');
            Route::get('/create', Admin\Admins\Create::class)->name('admin.admins.create');
            Route::get('/{id}/edit', Admin\Admins\Edit::class)->name('admin.admins.edit');
        });
        Route::prefix('employees')->group(function(){
            Route::get('/', Admin\Employees\Index::class)->name('admin.employees.index');
            Route::get('/create', Admin\Employees\Create::class)->name('admin.employees.create');
            Route::get('/{id}/edit', Admin\Employees\Edit::class)->name('admin.employees.edit');
        });

        Route::prefix('attendance')->group(function(){
            Route::get('/', Admin\Attendance\Index::class)->name('admin.attendance.index');
            Route::get('/create', Admin\Attendance\Create::class)->name('admin.attendance.create');
            Route::get('/{id}/edit', Admin\Attendance\Edit::class)->name('admin.attendance.edit');
        });

    });




    /**
     * Employees' Links
     */
    Route::middleware('employee')->prefix('employee')->group(function(){
        Route::get('dashboard', Employee\Dashboard::class)->name('employee.dashboard');
    });
});



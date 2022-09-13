<?php

use App\Http\Livewire\Admin;
use App\Http\Livewire\Employee;
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

        Route::prefix('attendances')->group(function(){
            Route::get('/', Admin\Attendances\Index::class)->name('admin.attendances.index');
            Route::get('/create', Admin\Attendances\Create::class)->name('admin.attendances.create');
            Route::get('/{id}/edit', Admin\Attendances\Edit::class)->name('admin.attendances.edit');
        });
        Route::prefix('product_categories')->group(function(){
            Route::get('/', Admin\ProductCategories\Index::class)->name('admin.product_categories.index');
            Route::get('/create', Admin\ProductCategories\Create::class)->name('admin.product_categories.create');
            Route::get('/{id}/edit', Admin\ProductCategories\Edit::class)->name('admin.product_categories.edit');
        });
        Route::prefix('products')->group(function(){
            Route::get('/', Admin\Products\Index::class)->name('admin.products.index');
            Route::get('/create', Admin\Products\Create::class)->name('admin.products.create');
            Route::get('/{id}/edit', Admin\Products\Edit::class)->name('admin.products.edit');
        });
        Route::prefix('asset_categories')->group(function(){
            Route::get('/', Admin\AssetCategories\Index::class)->name('admin.asset_categories.index');
            Route::get('/create', Admin\AssetCategories\Create::class)->name('admin.asset_categories.create');
            Route::get('/{id}/edit', Admin\AssetCategories\Edit::class)->name('admin.asset_categories.edit');
        });
        Route::prefix('assets')->group(function(){
            Route::get('/', Admin\Assets\Index::class)->name('admin.assets.index');
            Route::get('/create', Admin\Assets\Create::class)->name('admin.assets.create');
            Route::get('/{id}/edit', Admin\Assets\Edit::class)->name('admin.assets.edit');
        });

    });




    /**
     * Employees' Links
     */
    Route::middleware('employee')->prefix('employee')->group(function(){
        Route::get('dashboard', Employee\Dashboard::class)->name('employee.dashboard');
    });
});



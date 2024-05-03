<?php

use App\Http\Controllers\Api;
use App\Models\EmployeesDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('/login', [Api\UsersController::class, 'login']);


Route::middleware(['auth:sanctum', 'api-employee'])->group(function () {
    Route::get('/user', [Api\UsersController::class, 'getUser']);
});

Route::get('employees', function () {
    return EmployeesDetail::with(['user', 'ban', 'designation', 'contracts', 'attendances', 'leaves'])->get();
});

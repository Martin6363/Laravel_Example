<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(EmployeeController::class)->group(function () {
    Route::get('/', 'index')->name('employees');
    Route::post('employee/create', 'create')->name('employee_create');
    Route::delete('delete/{id}', 'delete');
    Route::get('/search','search')->name('search_employee');
});
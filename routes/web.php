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

Route::get('/', [EmployeeController::class, 'index'])->name('employee');
Route::post('employee/create', [EmployeeController::class, 'create'])->name('employee_create');
Route::delete('employee/{id}', [EmployeeController::class, 'destroy'])->name('delete_employee');
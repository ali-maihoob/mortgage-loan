<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::prefix('loan')->group(function () {
        Route::get('/', [LoanController::class, 'index'])->name('loan.index');
        Route::get('/create', [LoanController::class, 'create'])->name('loan.create');
        Route::get('/{id}', [LoanController::class, 'show'])->name('loan.show');
        Route::post('/store', [LoanController::class, 'store'])->name('loan.store');
        Route::post('/{loan}/extra-payment', [LoanController::class, 'addExtraPayment'])->name('loan.extra-payment');
    });
});


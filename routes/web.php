<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AddressUserController,
    InfoUserController
};

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/zip-code', [AddressUserController::class, 'zipcode'])->name('zipcode');

Route::get('/registers', [HomeController::class, 'viewRegisters'])->name('view.registers');
Route::get('/address', [AddressUserController::class, 'viewAddress'])->name('view.address');
Route::get('/expenses', [InfoUserController::class, 'viewExpenses'])->name('view.expenses');


Route::post('/registers', [HomeController::class, 'storeRegisterUser'])->name('redirectTo.address');
Route::post('/address', [AddressUserController::class, 'store'])->name('redirectTo.expenses');
Route::post('/expenses', [InfoUserController::class, 'store'])->name('finished');

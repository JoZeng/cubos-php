<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController; // Certifique-se de usar o namespace correto para HomeController
use App\Http\Controllers\ClientController; // Certifique-se de usar o namespace correto para HomeController
use App\Http\Controllers\ChargeController;

Route::get('/', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'storeStepOne'])->name('store.user');

Route::get('/senha', [UserController::class, 'password'])->name('password');
Route::post('/senha', [UserController::class, 'finalRegister'])->name('final.register');

Route::get('/confirmacao', [UserController::class, 'confirmation'])->name('confirm-register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('authenticate');

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');

Route::get('/clientes', [ClientController::class, 'index'])->name('clients')->middleware('auth');
Route::post('/clientes', [ClientController::class, 'store'])->name('clients.store');

Route::get('/cobrancas', [ChargeController::class, 'index'])->name('charges')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/cobrancas', [ChargeController::class, 'index'])->name('charges'); // Rota para listar cobranças
    Route::get('/charges/create', [ChargeController::class, 'create'])->name('charges.create');
    Route::post('/charges', [ChargeController::class, 'store'])->name('charges.store');
    Route::delete('/charges/{id}', [ChargeController::class, 'destroy'])->name('charges.delete');
    Route::put('/charges/{id}', [ChargeController::class, 'update'])->name('charges.update');
});


Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');
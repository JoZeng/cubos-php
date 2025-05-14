<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
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
Route::get('/clientes/{id}', [ClientController::class, 'detailsClients'])->name('clients-details')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/cobrancas', [ChargeController::class, 'index'])->name('charges');
    Route::get('/cobrancas/pagas', [ChargeController::class, 'pagas'])->name('charges.pagas');
    Route::get('/cobrancas/create', [ChargeController::class, 'create'])->name('charges.create');
    Route::post('/charges', [ChargeController::class, 'store'])->name('charges.store');
    Route::put('/clientes/{id}', [ChargeController::class, 'updateCharges'])->name('updateCharges');

// Deletar cobrança
    Route::delete('/charges/{id}', [ChargeController::class, 'destroy'])->name('charges.delete');
    Route::get('/charges/{id}', [ChargeController::class, 'show'])->name('charges.show');
});

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

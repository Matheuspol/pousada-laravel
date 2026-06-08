<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaQuartoController;
use App\Http\Controllers\HospedeController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\QuartoController;
use App\Http\Controllers\ReservaController;

/*
 Web Routes — Sistema de Gerenciamento de Pousada
*/

// Página Inicial (pública) 
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Autenticação 
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class,    'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class,    'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Rotas protegidas (requer autenticação) 
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Categorias de Quarto (CRUD básico — sem FK)
    Route::resource('categorias-quarto', CategoriaQuartoController::class);

    // Hóspedes (CRUD básico — sem FK)
    Route::resource('hospedes', HospedeController::class);

    // Funcionários (CRUD básico — sem FK)
    Route::resource('funcionarios', FuncionarioController::class);

    // Quartos (CRUD com FK → categorias_quarto)
    Route::resource('quartos', QuartoController::class);

    // Reservas (CRUD com FKs → hospedes, quartos, funcionarios)
    Route::resource('reservas', ReservaController::class);
});

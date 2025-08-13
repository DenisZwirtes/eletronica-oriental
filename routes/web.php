<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Proprietario\OrdemServicoController;
use App\Http\Controllers\Proprietario\ClienteController;

// Rota principal - redireciona para login se não autenticado
Route::get('/', function () {
    return redirect('/login');
});

// Rotas de autenticação
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rotas de registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rotas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas de Clientes (API)
    Route::prefix('api')->group(function () {
        Route::get('/clientes', [ClienteController::class, 'index'])->name('api.clientes.index');
    });

    // Rotas de Ordens de Serviço
    Route::prefix('ordens-servico')->name('ordens-servico.')->group(function () {
        Route::get('/', function () {
            return inertia('OrdensServico/Index');
        })->name('index');
        Route::get('/create', function () {
            return inertia('OrdensServico/Create');
        })->name('create');
        Route::get('/preview', [OrdemServicoController::class, 'preview'])->name('preview');
        Route::post('/', [OrdemServicoController::class, 'store'])->name('store');
        Route::get('/{ordemServico}', [OrdemServicoController::class, 'show'])->name('show');
        Route::put('/{ordemServico}', [OrdemServicoController::class, 'update'])->name('update');
        Route::delete('/{ordemServico}', [OrdemServicoController::class, 'destroy'])->name('destroy');
        Route::get('/{ordemServico}/imprimir', [OrdemServicoController::class, 'imprimir'])->name('imprimir');
    });
});

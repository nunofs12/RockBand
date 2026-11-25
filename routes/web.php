<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\BandController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Qualquer visitante pode consultar as bandas e os respetivos álbuns.
Route::get('/', [BandController::class, 'index'])->name('home');
Route::get('/bands', [BandController::class, 'index'])->name('bands.all');
Route::get('/bands/{band}', [BandController::class, 'show'])->name('bands.show');

// Login, registo e logout são rotas automáticas do Fortify.
Route::middleware('auth')->group(function () {
    Route::view('/profile', 'auth.profile')->name('profile');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User autenticado e administrador podem editar, mas não inserir ou apagar.
    Route::get('/bands/{band}/edit', [BandController::class, 'edit'])->name('bands.edit');
    Route::put('/bands/{band}', [BandController::class, 'update'])->name('bands.update');
    Route::get('/albums/{album}/edit', [AlbumController::class, 'edit'])->name('albums.edit');
    Route::put('/albums/{album}', [AlbumController::class, 'update'])->name('albums.update');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Criar e eliminar bandas: apenas administrador.
    Route::get('/admin/bands/add', [BandController::class, 'create'])->name('bands.add');
    Route::post('/admin/bands', [BandController::class, 'store'])->name('bands.store');
    Route::delete('/admin/bands/{band}', [BandController::class, 'destroy'])->name('bands.delete');

    // Criar e eliminar álbuns: apenas administrador.
    Route::get('/admin/bands/{band}/albums/add', [AlbumController::class, 'create'])->name('albums.add');
    Route::post('/admin/bands/{band}/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::delete('/admin/albums/{album}', [AlbumController::class, 'destroy'])->name('albums.delete');
});

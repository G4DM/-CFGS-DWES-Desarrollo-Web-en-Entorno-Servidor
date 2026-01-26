<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', [HomeController::class, 'getHome']);

    Route::get('/catalog', [CatalogController::class, 'getIndex']);
    Route::get('/catalog/show/{id}', [CatalogController::class, 'getShow']);

    Route::get('/catalog/create', [CatalogController::class, 'getCreate']); // Solo muestra la página
    Route::post('/catalog/create', [CatalogController::class, 'postCreate'])->name('catalog.postCreate'); // Se encarga de procesar los datos

    Route::get('/catalog/edit/{id}', [CatalogController::class, 'getEdit']);
    Route::put('/catalog/edit/{id}', [CatalogController::class, 'putEdit'])->name('catalog.putEdit'); // Procesa/Guarda los datos modificados
});

require __DIR__ . '/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CostoController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\SimulacionController;


Route::get('/', [SimulacionController::class, 'index'])->name('simulacion.index');
Route::post('/simular', [SimulacionController::class, 'store'])->name('simulacion.store');
Route::get('/resultado/{id}', [SimulacionController::class, 'resultado'])->name('simulacion.resultado');

// Ingresos
Route::resource('ingresos', IngresoController::class)->only(['index','create','store','destroy']);


Route::resource('costos', CostoController::class)->only(['index','create','store','destroy']);
Route::resource('gastos', GastoController::class)->only(['index','create','store','destroy']);

<?php

use App\Http\Controllers\CepController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PacientController;
use Illuminate\Support\Facades\Route;

Route::get('/pacients',          [PacientController::class, 'index']);
Route::get('/pacients/{id}',     [PacientController::class, 'show']);
Route::post('/pacients',         [PacientController::class, 'store']);
Route::put('/pacients/{id}',     [PacientController::class, 'update']);
Route::delete('/pacients/{id}',  [PacientController::class, 'destroy']);

Route::get('/cep',               [CepController::class, 'getCep']);

Route::post('/import-csv',       [ImportController::class, 'importCsv']);

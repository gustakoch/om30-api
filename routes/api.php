<?php

use App\Http\Controllers\CepController;
use App\Http\Controllers\PacientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/pacients',          [PacientController::class, 'index']);
Route::get('/pacients/{id}',     [PacientController::class, 'show']);
Route::post('/pacients',         [PacientController::class, 'store']);
Route::put('/pacients/{id}',     [PacientController::class, 'update']);
Route::delete('/pacients/{id}',  [PacientController::class, 'destroy']);
Route::get('/cep',               [CepController::class, 'getCep']);


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CocheController;
use App\Http\Controllers\RevisionController;

Route::apiResource('clientes', ClienteController::class);
Route::apiResource('coches', CocheController::class);
Route::apiResource('revisiones', RevisionController::class);

Route::get('/clientes/{id}/coches', [ClienteController::class, 'coches']);
Route::get('/coches-revisiones', [CocheController::class, 'conRevisiones']);
Route::get('/coches/{id}/historial', [RevisionController::class, 'historial']);

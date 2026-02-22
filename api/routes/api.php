<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TarefaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/teste', function() {
    return response()->json(['msg' => 'Conexão ok']);
});

Route::post('/cadastrar', [UsuarioController::class , 'cadastrar'] );
Route::post('/login', [UsuarioController::class , 'login'] );


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/newTask', [TarefaController::class, 'salvar']);
    Route::get('/listTask', [TarefaController::class, 'listar']);
    Route::delete('/excluirTask/{id}', [TarefaController::class, 'excluir']);
    Route::put('/concluirTask/{id}', [TarefaController::class, 'concluir']);
    Route::post('/logout', [UsuarioController::class, 'logout']);
});
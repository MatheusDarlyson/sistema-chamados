<?php

use App\Http\Controllers\ChamadoController;
use Illuminate\Support\Facades\Route;

// Rotas do sistema de chamados
Route::get('/', function () {
    return redirect()->route('chamados.index');
});


Route::get('/chamados', [ChamadoController::class, 'index'])->name('chamados.index'); // Rota para exibir a lista de chamados
Route::get('/chamados/criar', [ChamadoController::class, 'create'])->name('chamados.create'); // Rota para exibir o formulário de criação de chamado
Route::post('/chamados', [ChamadoController::class, 'store'])->name('chamados.store'); // Rota para criar um novo chamado
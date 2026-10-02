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
Route::get('/chamados/{chamado}', [ChamadoController::class, 'show'])->name('chamados.show'); // Rota para exibir os detalhes de um chamado específico
Route::get('/chamados/{chamado}/editar', [ChamadoController::class, 'edit'])->name('chamados.edit'); // Rota para exibir o formulário de edição de chamado
Route::put('/chamados/{chamado}', [ChamadoController::class, 'update'])->name('chamados.update'); // Rota para atualizar um chamado existente
Route::delete('/chamados/{chamado}', [ChamadoController::class, 'destroy'])->name('chamados.destroy'); // Rota para excluir um chamado existente
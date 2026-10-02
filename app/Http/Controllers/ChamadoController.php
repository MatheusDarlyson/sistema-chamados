<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChamadoRequest;
use App\Http\Requests\UpdateChamadoRequest;
use App\Models\Chamado;
use App\Models\Responsavel;
use App\Services\AtribuicaoChamadoService;
use Illuminate\Http\Request;

// Controller para gerenciar chamados

class ChamadoController extends Controller
{
    // Exibe a lista de chamados
    public function index(Request $request)
    {
        $query = Chamado::query()
            ->with('responsavel');// Carrega o relacionamento com o responsável
            
       if ($request->filled('status')) {
         $query->where('status', $request->input('status')); // Filtra por status, se fornecido
       }

       if ($request->filled('prioridade')) {
         $query->where('prioridade', $request->input('prioridade')); // Filtra por prioridade, se fornecido
       }

       if ($request->filled('responsavel_id')) {
         $query->where('responsavel_id', $request->input('responsavel_id')); // Filtra por responsável, se fornecido
       }

       $chamados = $query
        ->latest('data_abertura') // Ordena os chamados pela data de abertura, do mais recente para o mais antigo
        ->get();

       $responsaveis = Responsavel::query()
            ->orderBy('nome') // Ordena os responsáveis por nome
            ->get([
                'id',
                'nome',
            ]);

         return inertia('Chamados/Index', [
            'chamados' => $chamados, // Passa os chamados para a view Inertia
            'responsaveis' => $responsaveis, // Passa os responsáveis para a view Inertia
            'filtros' => [
                'status' => $request->input('status'), // Passa o filtro de status para a view Inertia
                'prioridade' => $request->input('prioridade'), // Passa o filtro de prioridade para a view Inertia
                'responsavel_id' => $request->input('responsavel_id'), // Passa o filtro de responsável para a view Inertia
            ]
        ]);
    }

    // Exibe o formulário para criar um novo chamado
    public function create()
    {
        $responsaveis = Responsavel::query()
            ->orderBy('nome') // Ordena os responsáveis por nome
            ->get([
                'id',
                'nome',
            ]);
            
        return inertia('Chamados/Create', [
            'responsaveis' => $responsaveis, // Passa os responsáveis para a view Inertia
        ]);
    }

    // Exibe os detalhes de um chamado específico
    public function show(Chamado $chamado)
    {
        $chamado->load('responsavel'); // Carrega o relacionamento com o responsável

        return inertia('Chamados/Show', [
            'chamado' => $chamado, // Passa o chamado para a view Inertia
        ]);
    }

    // Exibe o formulário para editar um chamado existente
    public function edit(Chamado $chamado)
    {
        $responsaveis = Responsavel::query()
            ->orderBy('nome') // Ordena os responsáveis por nome
            ->get([
                'id',
                'nome',
            ]);

        return inertia('Chamados/Edit', [
            'chamado' => $chamado, // Passa o chamado para a view Inertia
            'responsaveis' => $responsaveis, // Passa os responsáveis para a view Inertia
        ]);
    }

    // Atualiza um chamado existente no banco de dados
    public function update(
        UpdateChamadoRequest $request,
        Chamado $chamado
    ) {
        $chamado->update($request->validated()); // Atualiza o chamado com os dados validados

        return redirect()
            ->route('chamados.show', $chamado) // Redireciona para a página de detalhes do chamado atualizado
            ->with('success', 'Chamado atualizado com sucesso.');
    }

    // Exclui um chamado do banco de dados
    public function destroy(Chamado $chamado)
    {
        $chamado->delete(); // Exclui o chamado do banco de dados

        return redirect()
            ->route('chamados.index')
            ->with('success', 'Chamado excluído com sucesso.');
    }


    // Armazena um novo chamado no banco de dados
    public function store(
        StoreChamadoRequest $request,
        AtribuicaoChamadoService $atribuicaoService
    ) {
        $dados = $request->validated(); // Valida os dados recebidos na requisição

        if (empty($dados['responsavel_id'])) { // Se o campo 'responsavel_id' estiver vazio, atribui um responsável automaticamente
            $responsavel = $atribuicaoService->atribuirChamado();

            $dados['responsavel_id'] = $responsavel->id; // Atribui o ID do responsável encontrado ao campo 'responsavel_id' dos dados do chamado
        }

        $dados['data_abertura'] = now();

        Chamado::create($dados);

        return redirect()
            ->route('chamados.index')
            ->with('success', 'Chamado criado com sucesso.');
    }
}
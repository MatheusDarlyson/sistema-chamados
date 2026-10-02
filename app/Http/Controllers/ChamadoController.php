<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChamadoRequest;
use App\Models\Chamado;
use App\Models\Responsavel;
use App\Services\AtribuicaoChamadoService;

// Controller para gerenciar chamados

class ChamadoController extends Controller
{
    public function index()
    {
        $chamados = Chamado::query()
            ->with('responsavel') // Carrega o relacionamento com o responsável
            ->latest('data_abertura') // Ordena por data de abertura (mais recente primeiro)
            ->get();

        return inertia('Chamados/Index', [
            'chamados' => $chamados, // Passa os chamados para a view Inertia
        ]);
    }

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
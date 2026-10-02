<?php

namespace App\Services;

use App\StatusChamado;
use App\Models\Responsavel;

class AtribuicaoChamadoService

// funcao para redirecionar o chamado para o responsavel com menos chamados abertos

{
    public function atribuirChamado(): Responsavel
    {
        return Responsavel::query()
            ->withCount([
                'chamados as chamados_abertos' => function ($query) {
                    $query->whereIn('status', [
                        StatusChamado::ABERTO->value,
                        StatusChamado::EM_ANDAMENTO->value
                    ]);
                },
            ])
            ->orderBy('chamados_abertos')
            ->orderBy('id')
            ->firstOrFail();
    }
}

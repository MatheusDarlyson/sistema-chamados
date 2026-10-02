<?php

namespace Tests\Feature;

use App\StatusChamado;
use App\Models\Chamado;
use App\Models\Responsavel;
use App\Services\AtribuicaoChamadoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AtribuicaoChamadoServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_seleciona_responsavel_com_menos_chamados_em_aberto(): void // Testa se o serviço seleciona corretamente o responsável com menos chamados em aberto
    {
        $ana = Responsavel::create([ 
            'nome' => 'Ana Silva',
        ]);

        $carlos = Responsavel::create([
            'nome' => 'Carlos Oliveira',
        ]);

        $mariana = Responsavel::create([
            'nome' => 'Mariana Costa',
        ]);

        $this->criarChamados($ana, 3);
        $this->criarChamados($carlos, 1);
        $this->criarChamados($mariana, 2);

        $responsavel = app(AtribuicaoChamadoService::class) 
            ->atribuirChamado();

        $this->assertSame($carlos->id, $responsavel->id);
    }

    public function test_nao_considera_chamados_concluidos_na_distribuicao(): void // Testa se o serviço não considera chamados concluídos na distribuição
    {
        $ana = Responsavel::create([
            'nome' => 'Ana Silva',
        ]);

        $carlos = Responsavel::create([
            'nome' => 'Carlos Oliveira',
        ]);

        $this->criarChamados(
            $ana,
            5,
            StatusChamado::CONCLUIDO
        );

        $this->criarChamados(
            $carlos,
            1,
            StatusChamado::ABERTO
        );

        $responsavel = app(AtribuicaoChamadoService::class)
            ->atribuirChamado();

        $this->assertSame($ana->id, $responsavel->id);
    }

    private function criarChamados(
        Responsavel $responsavel,
        int $quantidade,
        StatusChamado $status = StatusChamado::ABERTO
    ): void {
        for ($i = 0; $i < $quantidade; $i++) {
            Chamado::create([
                'titulo' => 'Chamado de teste',
                'descricao' => 'Descrição do chamado de teste.',
                'prioridade' => 'Média',
                'status' => $status,
                'responsavel_id' => $responsavel->id,
                'data_abertura' => now(),
            ]);
        }
    }
}
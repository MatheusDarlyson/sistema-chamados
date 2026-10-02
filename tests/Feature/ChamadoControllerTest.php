<?php

namespace Tests\Feature;

use App\Models\Chamado;
use App\Models\Responsavel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// Teste de funcionalidade para o ChamadoController
class ChamadoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_pode_criar_chamado_com_responsavel_informado(): void
    {
        $responsavel = Responsavel::create([
            'nome' => 'Ana Silva',
        ]);

        $response = $this->post('/chamados', [
            'titulo' => 'Computador não liga',
            'descricao' => 'O computador do setor administrativo não inicia.',
            'prioridade' => 'Alta',
            'status' => 'Aberto',
            'responsavel_id' => $responsavel->id,
        ]);

        $response->assertRedirect('/chamados');

        $this->assertDatabaseHas('chamados', [
            'titulo' => 'Computador não liga',
            'responsavel_id' => $responsavel->id,
            'prioridade' => 'Alta',
            'status' => 'Aberto',
        ]);

        $this->assertDatabaseCount('chamados', 1);
    }

    public function test_atribui_responsavel_automaticamente_ao_criar_chamado(): void
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

    Chamado::create([
        'titulo' => 'Chamado existente',
        'descricao' => 'Chamado para testar a distribuição.',
        'prioridade' => 'Média',
        'status' => 'Aberto',
        'responsavel_id' => $ana->id,
        'data_abertura' => now(),
    ]);

    $response = $this->post('/chamados', [
        'titulo' => 'Novo chamado',
        'descricao' => 'Este chamado deve ser atribuído automaticamente.',
        'prioridade' => 'Alta',
        'status' => 'Aberto',
    ]);

    $response->assertRedirect('/chamados');

    $this->assertDatabaseHas('chamados', [
        'titulo' => 'Novo chamado',
        'responsavel_id' => $carlos->id,
    ]);
}

    public function test_pode_visualizar_um_chamado(): void
{
    $responsavel = Responsavel::create([
        'nome' => 'Ana Silva',
    ]);

    $chamado = Chamado::create([
        'titulo' => 'Computador não liga',
        'descricao' => 'O computador do setor administrativo não inicia.',
        'prioridade' => 'Alta',
        'status' => 'Aberto',
        'responsavel_id' => $responsavel->id,
        'data_abertura' => now(),
    ]);

    $response = $this->get("/chamados/{$chamado->id}");

    $response->assertOk();

    $response->assertInertia(fn ($page) => $page
        ->component('Chamados/Show')
        ->where('chamado.id', $chamado->id)
        ->where('chamado.titulo', 'Computador não liga')
        ->where('chamado.responsavel_id', $responsavel->id)
    );
}

    public function test_pode_editar_um_chamado(): void
{
    $responsavel = Responsavel::create([
        'nome' => 'Ana Silva',
    ]);

    $novoResponsavel = Responsavel::create([
        'nome' => 'Carlos Oliveira',
    ]);

    $chamado = Chamado::create([
        'titulo' => 'Computador não liga',
        'descricao' => 'O computador do setor administrativo não inicia.',
        'prioridade' => 'Alta',
        'status' => 'Aberto',
        'responsavel_id' => $responsavel->id,
        'data_abertura' => now(),
    ]);

    $response = $this->put("/chamados/{$chamado->id}", [
        'titulo' => 'Computador com problema',
        'descricao' => 'O computador continua apresentando problemas.',
        'prioridade' => 'Média',
        'status' => 'Em andamento',
        'responsavel_id' => $novoResponsavel->id,
    ]);

    $response->assertRedirect("/chamados/{$chamado->id}");

    $this->assertDatabaseHas('chamados', [
        'id' => $chamado->id,
        'titulo' => 'Computador com problema',
        'prioridade' => 'Média',
        'status' => 'Em andamento',
        'responsavel_id' => $novoResponsavel->id,
    ]);
}

    public function test_pode_excluir_um_chamado(): void
{
    $responsavel = Responsavel::create([
        'nome' => 'Ana Silva',
    ]);

    $chamado = Chamado::create([
        'titulo' => 'Chamado para excluir',
        'descricao' => 'Este chamado será removido durante o teste.',
        'prioridade' => 'Baixa',
        'status' => 'Aberto',
        'responsavel_id' => $responsavel->id,
        'data_abertura' => now(),
    ]);

    $response = $this->delete("/chamados/{$chamado->id}");

    $response->assertRedirect('/chamados');

    $this->assertDatabaseMissing('chamados', [
        'id' => $chamado->id,
    ]);
}


    public function test_nao_pode_criar_chamado_sem_titulo(): void
{
    $responsavel = Responsavel::create([
        'nome' => 'Ana Silva',
    ]);

    $response = $this->post('/chamados', [
        'titulo' => '',
        'descricao' => 'Descrição válida.',
        'prioridade' => 'Alta',
        'status' => 'Aberto',
        'responsavel_id' => $responsavel->id,
    ]);

    $response->assertSessionHasErrors('titulo');

    $this->assertDatabaseCount('chamados', 0);
}


}
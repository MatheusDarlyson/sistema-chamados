<?php

namespace App\Models;

use App\PrioridadeChamado;
use App\StatusChamado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


// Model que representa um chamado no sistema de chamados
class Chamado extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'prioridade',
        'status',
        'responsavel_id',
        'data_abertura',
    ];


    protected function casts(): array // Define os tipos de dados para os atributos do modelo
    {
        return [
            'prioridade' => PrioridadeChamado::class,
            'status' => StatusChamado::class,
            'data_abertura' => 'datetime',
        ];
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(Responsavel::class);
    }
}

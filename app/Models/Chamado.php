<?php

namespace App\Models;

use App\Enums\PrioridadeChamado;
use App\Enums\StatusChamado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chamado extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'categoria',
        'prioridade',
        'status',
        'responsavel_id',
        'data_abertura',
    ];


    protected function casts(): array
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

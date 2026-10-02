<?php

namespace App\Enums;

enum StatusChamado: string
{
    case ABERTO = 'Aberto';
    case EM_ANDAMENTO = 'Em andamento';
    case CONCLUIDO = 'Concluído';

    public function label(): string
    {
        return match ($this) {
            self::ABERTO => 'Aberto',
            self::EM_ANDAMENTO => 'Em andamento',
            self::CONCLUIDO => 'Concluído',
        };
    }
}

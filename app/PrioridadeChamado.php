<?php

namespace App\Enums;

enum PrioridadeChamado: string
{
    case BAIXA = 'Baixa';
    case MEDIA = 'Média';
    case ALTA = 'Alta';

    public function label(): string
    {
        return match ($this) {
            self::BAIXA => 'Baixa',
            self::MEDIA => 'Média',
            self::ALTA => 'Alta',
        };
    }
}

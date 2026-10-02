<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Responsavel extends Model 
{
    protected $table = 'responsaveis';
    
    protected $fillable = [
        'nome',
    ];

    public function chamados(): HasMany
    {
        return $this->hasMany(Chamado::class);
    }
}

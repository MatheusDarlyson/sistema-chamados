<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateChamadoRequest extends FormRequest
{
    public function authorize(): bool 
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => [
                'required',
                'string',
                'max:255',
            ],

            'descricao' => [
                'required',
                'string',
            ],

            'prioridade' => [
                'required',
                Rule::in([
                    'Baixa',
                    'Média',
                    'Alta',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'Aberto',
                    'Em andamento',
                    'Concluído',
                ]),
            ],

            'responsavel_id' => [
                'required',
                'exists:responsaveis,id',
            ],
        ];
    }
}
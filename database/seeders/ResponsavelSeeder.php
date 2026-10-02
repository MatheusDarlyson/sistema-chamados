<?php

namespace Database\Seeders;

use App\Models\Responsavel;
use Illuminate\Database\Seeder;

class ResponsavelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Responsavel::create([
            'nome' => 'Ana Silva',
        ]);

        Responsavel::create([
            'nome' => 'Carlos Oliveira',
        ]);

        Responsavel::create([
            'nome' => 'Mariana Costa',
        ]);
    }
}

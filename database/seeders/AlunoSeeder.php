<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aluno;

class AlunoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alunos = [
            [
                'nome' => 'Maria Silva',
                'email' => 'maria.silva@email.com',
                'data_nascimento' => '1998-03-15'
            ],
            [
                'nome' => 'João Santos',
                'email' => 'joao.santos@email.com',
                'data_nascimento' => '1999-07-22'
            ],
            [
                'nome' => 'Ana Costa',
                'email' => 'ana.costa@email.com',
                'data_nascimento' => '1997-11-08'
            ],
            [
                'nome' => 'Pedro Oliveira',
                'email' => 'pedro.oliveira@email.com',
                'data_nascimento' => '2000-01-30'
            ],
            [
                'nome' => 'Julia Ferreira',
                'email' => 'julia.ferreira@email.com',
                'data_nascimento' => '1998-09-12'
            ],
            [
                'nome' => 'Lucas Rodrigues',
                'email' => 'lucas.rodrigues@email.com',
                'data_nascimento' => '1999-05-25'
            ],
            [
                'nome' => 'Camila Alves',
                'email' => 'camila.alves@email.com',
                'data_nascimento' => '1997-12-03'
            ],
            [
                'nome' => 'Rafael Lima',
                'email' => 'rafael.lima@email.com',
                'data_nascimento' => '2000-04-18'
            ]
        ];

        foreach ($alunos as $aluno) {
            Aluno::create($aluno);
        }
    }
}

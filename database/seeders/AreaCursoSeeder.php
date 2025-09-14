<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AreaCurso;

class AreaCursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areasCursos = [
            [
                'titulo' => 'Biologia',
                'descricao' => 'Curso completo de Biologia, abordando desde citologia até ecologia, preparando o aluno para vestibulares e ENEM.'
            ],
            [
                'titulo' => 'Química',
                'descricao' => 'Curso de Química geral, orgânica e inorgânica com foco em resolução de exercícios e experimentos práticos.'
            ],
            [
                'titulo' => 'Física',
                'descricao' => 'Curso de Física mecânica, termodinâmica, eletromagnetismo e física moderna com metodologia inovadora.'
            ],
            [
                'titulo' => 'Matemática',
                'descricao' => 'Curso de Matemática básica e avançada, álgebra, geometria e cálculo para ensino médio e pré-vestibular.'
            ],
            [
                'titulo' => 'Português',
                'descricao' => 'Curso de Língua Portuguesa, gramática, literatura e redação com técnicas de interpretação de texto.'
            ]
        ];

        foreach ($areasCursos as $area) {
            AreaCurso::create($area);
        }
    }
}

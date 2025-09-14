<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Matricula;

class MatriculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matriculas = [
            // Maria Silva - Biologia e Química
            ['aluno_id' => 1, 'area_curso_id' => 1, 'status' => 'ativa'],
            ['aluno_id' => 1, 'area_curso_id' => 2, 'status' => 'ativa'],
            
            // João Santos - Física e Matemática
            ['aluno_id' => 2, 'area_curso_id' => 3, 'status' => 'ativa'],
            ['aluno_id' => 2, 'area_curso_id' => 4, 'status' => 'ativa'],
            
            // Ana Costa - Biologia (concluída) e Português
            ['aluno_id' => 3, 'area_curso_id' => 1, 'status' => 'concluida'],
            ['aluno_id' => 3, 'area_curso_id' => 5, 'status' => 'ativa'],
            
            // Pedro Oliveira - Química e Física
            ['aluno_id' => 4, 'area_curso_id' => 2, 'status' => 'ativa'],
            ['aluno_id' => 4, 'area_curso_id' => 3, 'status' => 'ativa'],
            
            // Julia Ferreira - Biologia
            ['aluno_id' => 5, 'area_curso_id' => 1, 'status' => 'ativa'],
            
            // Lucas Rodrigues - Matemática e Português
            ['aluno_id' => 6, 'area_curso_id' => 4, 'status' => 'ativa'],
            ['aluno_id' => 6, 'area_curso_id' => 5, 'status' => 'ativa'],
            
            // Camila Alves - Química (inativa) e Biologia
            ['aluno_id' => 7, 'area_curso_id' => 2, 'status' => 'inativa'],
            ['aluno_id' => 7, 'area_curso_id' => 1, 'status' => 'ativa'],
            
            // Rafael Lima - Física
            ['aluno_id' => 8, 'area_curso_id' => 3, 'status' => 'ativa']
        ];

        foreach ($matriculas as $matricula) {
            Matricula::create($matricula);
        }
    }
}

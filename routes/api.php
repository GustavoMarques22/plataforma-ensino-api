<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AreaCursoController;
use App\Http\Controllers\MatriculaController;

// Rota de informações da API
Route::get('/', function () {
    return response()->json([
        'api' => 'Plataforma de Ensino - Atividade de Revisão',
        'version' => '1.0.0',
        'description' => 'API REST para gerenciar alunos, áreas de cursos e matrículas',
        'endpoints' => [
            'alunos' => '/api/alunos',
            'areas_cursos' => '/api/areas-cursos',
            'matriculas' => '/api/matriculas',
            'documentacao' => '/api/docs'
        ]
    ]);
});

// Rota de documentação da API
Route::get('/docs', function () {
    return response()->json([
        'api_documentation' => [
            'alunos' => [
                'GET /api/alunos' => 'Listar todos os alunos (com busca por nome e email)',
                'GET /api/alunos/{id}' => 'Buscar aluno específico por ID',
                'POST /api/alunos' => 'Criar novo aluno',
                'PUT /api/alunos/{id}' => 'Atualizar aluno existente',
                'DELETE /api/alunos/{id}' => 'Excluir aluno'
            ],
            'areas_cursos' => [
                'GET /api/areas-cursos' => 'Listar todas as áreas de cursos',
                'GET /api/areas-cursos/{id}' => 'Buscar área de curso específica por ID',
                'POST /api/areas-cursos' => 'Criar nova área de curso',
                'PUT /api/areas-cursos/{id}' => 'Atualizar área de curso existente',
                'DELETE /api/areas-cursos/{id}' => 'Excluir área de curso'
            ],
            'matriculas' => [
                'GET /api/matriculas' => 'Listar todas as matrículas',
                'GET /api/matriculas/{id}' => 'Buscar matrícula específica por ID',
                'POST /api/matriculas' => 'Criar nova matrícula',
                'PUT /api/matriculas/{id}' => 'Atualizar matrícula existente',
                'DELETE /api/matriculas/{id}' => 'Excluir matrícula',
                'GET /api/matriculas/aluno/{id}' => 'Listar matrículas de um aluno',
                'GET /api/matriculas/area-curso/{id}' => 'Listar matrículas de uma área de curso'
            ]
        ],
        'parametros_busca' => [
            'alunos' => [
                'nome' => 'Busca parcial por nome do aluno',
                'email' => 'Busca parcial por email do aluno',
                'per_page' => 'Quantidade de registros por página (padrão: 10)'
            ],
            'areas_cursos' => [
                'titulo' => 'Busca parcial por título da área de curso',
                'per_page' => 'Quantidade de registros por página (padrão: 10)'
            ],
            'matriculas' => [
                'status' => 'Filtrar por status (ativa, inativa, concluida)',
                'per_page' => 'Quantidade de registros por página (padrão: 10)'
            ]
        ],
        'exemplos' => [
            'criar_aluno' => [
                'method' => 'POST',
                'url' => '/api/alunos',
                'body' => [
                    'nome' => 'João Silva',
                    'email' => 'joao@email.com',
                    'data_nascimento' => '1995-05-15'
                ]
            ],
            'criar_area_curso' => [
                'method' => 'POST',
                'url' => '/api/areas-cursos',
                'body' => [
                    'titulo' => 'Biologia',
                    'descricao' => 'Curso completo de Biologia'
                ]
            ],
            'criar_matricula' => [
                'method' => 'POST',
                'url' => '/api/matriculas',
                'body' => [
                    'aluno_id' => 1,
                    'area_curso_id' => 1,
                    'status' => 'ativa'
                ]
            ]
        ]
    ]);
});

// Rotas de recursos (Resource Routes)
Route::apiResource('alunos', AlunoController::class);
Route::apiResource('areas-cursos', AreaCursoController::class);
Route::apiResource('matriculas', MatriculaController::class);

// Rotas adicionais para matrículas
Route::get('matriculas/aluno/{alunoId}', [MatriculaController::class, 'matriculasPorAluno']);
Route::get('matriculas/area-curso/{areaCursoId}', [MatriculaController::class, 'matriculasPorAreaCurso']);

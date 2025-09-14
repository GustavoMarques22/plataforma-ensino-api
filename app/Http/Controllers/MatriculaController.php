<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Aluno;
use App\Models\AreaCurso;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class MatriculaController extends Controller
{
    /**
     * Lista todas as matrículas com filtros opcionais
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Matricula::with(['aluno', 'areaCurso']);

            // Filtro por status
            if ($request->has('status')) {
                $query->byStatus($request->status);
            }

            // Paginação
            $perPage = $request->get('per_page', 10);
            $matriculas = $query->orderBy('data_matricula', 'desc')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $matriculas->items(),
                'pagination' => [
                    'current_page' => $matriculas->currentPage(),
                    'total' => $matriculas->total(),
                    'per_page' => $matriculas->perPage(),
                    'last_page' => $matriculas->lastPage(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar matrículas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibe uma matrícula específica
     */
    public function show($id): JsonResponse
    {
        try {
            $matricula = Matricula::with(['aluno', 'areaCurso'])->find($id);

            if (!$matricula) {
                return response()->json([
                    'success' => false,
                    'message' => 'Matrícula não encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $matricula
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar matrícula',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cria uma nova matrícula
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'aluno_id' => 'required|exists:alunos,id',
                'area_curso_id' => 'required|exists:area_cursos,id',
                'status' => 'nullable|in:ativa,inativa,concluida',
                'data_matricula' => 'nullable|date'
            ]);

            // Verificar se já existe uma matrícula ativa para este aluno e área de curso
            $matriculaExistente = Matricula::where('aluno_id', $validated['aluno_id'])
                                          ->where('area_curso_id', $validated['area_curso_id'])
                                          ->where('status', 'ativa')
                                          ->exists();

            if ($matriculaExistente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este aluno já possui uma matrícula ativa nesta área de curso'
                ], 422);
            }

            // Definir status padrão se não fornecido
            if (!isset($validated['status'])) {
                $validated['status'] = 'ativa';
            }

            // Definir data de matrícula se não fornecida
            if (!isset($validated['data_matricula'])) {
                $validated['data_matricula'] = now();
            }

            $matricula = Matricula::create($validated);
            $matricula->load(['aluno', 'areaCurso']);

            return response()->json([
                'success' => true,
                'message' => 'Matrícula criada com sucesso',
                'data' => $matricula
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar matrícula',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualiza uma matrícula existente
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $matricula = Matricula::find($id);

            if (!$matricula) {
                return response()->json([
                    'success' => false,
                    'message' => 'Matrícula não encontrada'
                ], 404);
            }

            $validated = $request->validate([
                'status' => 'sometimes|in:ativa,inativa,concluida',
                'data_matricula' => 'sometimes|date'
            ]);

            $matricula->update($validated);
            $matricula->load(['aluno', 'areaCurso']);

            return response()->json([
                'success' => true,
                'message' => 'Matrícula atualizada com sucesso',
                'data' => $matricula
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar matrícula',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove uma matrícula
     */
    public function destroy($id): JsonResponse
    {
        try {
            $matricula = Matricula::find($id);

            if (!$matricula) {
                return response()->json([
                    'success' => false,
                    'message' => 'Matrícula não encontrada'
                ], 404);
            }

            $matricula->delete();

            return response()->json([
                'success' => true,
                'message' => 'Matrícula excluída com sucesso'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir matrícula',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lista matrículas de um aluno específico
     */
    public function matriculasPorAluno($alunoId): JsonResponse
    {
        try {
            $aluno = Aluno::find($alunoId);

            if (!$aluno) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aluno não encontrado'
                ], 404);
            }

            $matriculas = Matricula::with(['areaCurso'])
                                  ->where('aluno_id', $alunoId)
                                  ->orderBy('data_matricula', 'desc')
                                  ->get();

            return response()->json([
                'success' => true,
                'aluno' => $aluno,
                'matriculas' => $matriculas,
                'total' => $matriculas->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar matrículas do aluno',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lista matrículas de uma área de curso específica
     */
    public function matriculasPorAreaCurso($areaCursoId): JsonResponse
    {
        try {
            $areaCurso = AreaCurso::find($areaCursoId);

            if (!$areaCurso) {
                return response()->json([
                    'success' => false,
                    'message' => 'Área de curso não encontrada'
                ], 404);
            }

            $matriculas = Matricula::with(['aluno'])
                                  ->where('area_curso_id', $areaCursoId)
                                  ->orderBy('data_matricula', 'desc')
                                  ->get();

            return response()->json([
                'success' => true,
                'area_curso' => $areaCurso,
                'matriculas' => $matriculas,
                'total' => $matriculas->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar matrículas da área de curso',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
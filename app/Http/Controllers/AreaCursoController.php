<?php

namespace App\Http\Controllers;

use App\Models\AreaCurso;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AreaCursoController extends Controller
{
    /**
     * Lista todas as áreas de curso com opção de busca por título
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = AreaCurso::with(['alunos', 'matriculas']);

            // Filtro por título se fornecido
            if ($request->has('titulo')) {
                $query->byTitulo($request->titulo);
            }

            // Paginação
            $perPage = $request->get('per_page', 10);
            $areaCursos = $query->orderBy('titulo')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $areaCursos->items(),
                'pagination' => [
                    'current_page' => $areaCursos->currentPage(),
                    'total' => $areaCursos->total(),
                    'per_page' => $areaCursos->perPage(),
                    'last_page' => $areaCursos->lastPage(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar áreas de curso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibe uma área de curso específica
     */
    public function show($id): JsonResponse
    {
        try {
            $areaCurso = AreaCurso::with(['alunos', 'matriculas.aluno'])->find($id);

            if (!$areaCurso) {
                return response()->json([
                    'success' => false,
                    'message' => 'Área de curso não encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $areaCurso
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar área de curso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cria uma nova área de curso
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'titulo' => 'required|string|max:255|unique:area_cursos,titulo',
                'descricao' => 'nullable|string|max:1000'
            ]);

            $areaCurso = AreaCurso::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Área de curso criada com sucesso',
                'data' => $areaCurso
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
                'message' => 'Erro ao criar área de curso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualiza uma área de curso existente
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $areaCurso = AreaCurso::find($id);

            if (!$areaCurso) {
                return response()->json([
                    'success' => false,
                    'message' => 'Área de curso não encontrada'
                ], 404);
            }

            $validated = $request->validate([
                'titulo' => 'sometimes|string|max:255|unique:area_cursos,titulo,' . $id,
                'descricao' => 'nullable|string|max:1000'
            ]);

            $areaCurso->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Área de curso atualizada com sucesso',
                'data' => $areaCurso->fresh()
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
                'message' => 'Erro ao atualizar área de curso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove uma área de curso
     */
    public function destroy($id): JsonResponse
    {
        try {
            $areaCurso = AreaCurso::find($id);

            if (!$areaCurso) {
                return response()->json([
                    'success' => false,
                    'message' => 'Área de curso não encontrada'
                ], 404);
            }

            // Verificar se existem matrículas ativas
            $matriculasAtivas = $areaCurso->matriculas()->where('status', 'ativa')->count();

            if ($matriculasAtivas > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Não é possível excluir uma área de curso com matrículas ativas'
                ], 422);
            }

            $areaCurso->delete();

            return response()->json([
                'success' => true,
                'message' => 'Área de curso excluída com sucesso'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir área de curso',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
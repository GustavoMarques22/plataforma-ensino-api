<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AlunoController extends Controller
{
    /**
     * Lista todos os alunos com opções de busca
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Aluno::with(['areaCursos', 'matriculas.areaCurso']);

            // Filtros de busca
            if ($request->has('nome')) {
                $query->byNome($request->nome);
            }

            if ($request->has('email')) {
                $query->byEmail($request->email);
            }

            // Paginação
            $perPage = $request->get('per_page', 10);
            $alunos = $query->orderBy('nome')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $alunos->items(),
                'pagination' => [
                    'current_page' => $alunos->currentPage(),
                    'total' => $alunos->total(),
                    'per_page' => $alunos->perPage(),
                    'last_page' => $alunos->lastPage(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao listar alunos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibe um aluno específico
     */
    public function show($id): JsonResponse
    {
        try {
            $aluno = Aluno::with(['areaCursos', 'matriculas.areaCurso'])->find($id);

            if (!$aluno) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aluno não encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $aluno
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar aluno',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cria um novo aluno
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|email|unique:alunos,email',
                'data_nascimento' => 'nullable|date|before:today'
            ]);

            $aluno = Aluno::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Aluno criado com sucesso',
                'data' => $aluno
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
                'message' => 'Erro ao criar aluno',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualiza um aluno existente
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $aluno = Aluno::find($id);

            if (!$aluno) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aluno não encontrado'
                ], 404);
            }

            $validated = $request->validate([
                'nome' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:alunos,email,' . $id,
                'data_nascimento' => 'nullable|date|before:today'
            ]);

            $aluno->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Aluno atualizado com sucesso',
                'data' => $aluno->fresh()
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
                'message' => 'Erro ao atualizar aluno',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove um aluno
     */
    public function destroy($id): JsonResponse
    {
        try {
            $aluno = Aluno::find($id);

            if (!$aluno) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aluno não encontrado'
                ], 404);
            }

            // Verificar se existem matrículas ativas
            $matriculasAtivas = $aluno->matriculas()->where('status', 'ativa')->count();

            if ($matriculasAtivas > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Não é possível excluir um aluno com matrículas ativas'
                ], 422);
            }

            $aluno->delete();

            return response()->json([
                'success' => true,
                'message' => 'Aluno excluído com sucesso'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir aluno',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
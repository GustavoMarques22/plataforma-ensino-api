<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->foreignID('aluno_id')->constrained('alunos')->onDelete('cascade');
            $table->foreignID('area_curso_id')->constrained('area_cursos')->onDelete('cascade');
            $table->enum('status', ['ativa', 'inativa', 'concluida'])->default('ativa');
            $table->timestamp('data_matricula')->useCurrent();
            $table->timestamps();

            // Evitar matrículas duplicadas para o mesmo aluno e curso
            $table->unique(['aluno_id', 'area_curso_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};

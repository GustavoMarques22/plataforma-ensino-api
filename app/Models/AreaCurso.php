<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AreaCurso extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao,'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime,'
    ];

    /**
    * Relacionamento com Alunos (muitos para muitos através de Matrícula)
    */
    public function alunos(): BelongsToMany 
    {
        return $this->belongsToMany(Aluno::class, 'matriculas')
                    ->withPivot('status', 'data_matricula')
                    ->withTimestamps();
    }

    /**
     * Relacionamento com Matriculas
     */
    public function matriculas(): HasMany
    {
        return $this->hasMany(Matricula::class);
    }

    /**
     * Escopo para busca por titulo
     */
    public function scopeByTitulo($query, $titulo)
    {
        return $query->where('titulo', 'like', '%' . $titulo . '%');
    }
}

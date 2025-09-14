<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'data_nascimento',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento com AreaCursos (muitos para muitos através de Matricula)
     */
    public function areaCursos(): BelongsToMany
    {
        return $this->belongsToMany(AreaCurso::class, 'matriculas')
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
     * Escopo para busca por nome
     */
    public function scopeByNome($query, $nome)
    {
        return $query->where('nome', 'like', '%' . $nome . '%');
    }

    /**
     * Escopo para busca por email
     */
    public function scopeByEmail($query, $email)
    {
        return $query->where('email', 'like', '%' . $email . '%');
    }
}

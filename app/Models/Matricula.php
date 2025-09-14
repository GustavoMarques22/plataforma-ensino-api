<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Matricula extends Model
{
    use HasFactory;

    protected $fillable=[
        'aluno_id',
        'area_curso_id',
        'status',
        'data_matricula',
    ];

    protected $casts=[
        'data_matricula' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento com Aluno
     */
    public function aluno(): BelongsTo
    {
        return $this->belongsTo(Aluno::class);
    }

    /**
     * Escopo para filtrar por status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Escopo para matrículas ativas
     */
    public function scopeAtivas($query)
    {
        return $query->where('status', 'ativa');
    }
}

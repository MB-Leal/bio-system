<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Student extends Model
{
    protected $fillable = [
        'group_id',
        'name',
        'phone',
        'email',
        'cell_group',
        'birth_date',
        'gender',
        'height',
        'weight',
        'sitting_time',
        'physical_activity',
        'surgeries',
        'orthopedic_issues',
        'has_fracture',
        'fracture_location',
        'fracture_date',
        'implants_details',
        'health_notes',
        'exam_pdf_path'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'created_at' => 'datetime',
    ];

    /**
     * Padroniza a altura para metros antes de salvar no banco.
     */
    protected function height(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value > 3 ? $value / 100 : $value,
        );
    }

    /**
     * Relacionamento: O aluno pertence a um grupo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Relacionamento: O aluno possui muitas avaliações físicas
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * Relacionamento: O aluno possui muitos registros de presença (CHAVE DA CORREÇÃO)
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
    /**
     * Retorna a avaliação mais recente ou os dados de cadastro se não houver.
     */
    public function getCurrentStats()
    {
        $latest = $this->evaluations()->orderBy('evaluation_date', 'desc')->first();

        return (object) [
            'weight' => $latest->weight ?? $this->weight,
            'waist' => $latest->waist ?? $this->waist,
            'body_fat_pct' => $latest->body_fat_pct ?? $this->body_fat_pct,
            'is_latest' => (bool)$latest,
            'date' => $latest ? $latest->evaluation_date : $this->created_at
        ];
    }
}

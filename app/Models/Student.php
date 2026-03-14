<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'group_id',
        'name',
        'phone',
        'email',
        'birth_date',
        'gender',
        'height',
        'weight',
        'health_notes',
        'is_smoker',
        'is_hypertensive',
        'is_diabetic',
        'has_pacemaker',
        'is_epileptic',
        'surgeries',
        'children_count',
        'is_pregnant',
        'contraception_method',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'created_at' => 'datetime',
    ];

    /**
     * Relacionamento: O aluno pertence a um grupo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Relacionamento: O aluno possui muitas avaliações
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * Relacionamento: O aluno possui muitos registros de presença
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}

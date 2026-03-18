<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
    'group_id', 'name', 'phone', 'email', 'cell_group','birth_date', 'gender',
    'height', 'weight', 'bust', 'waist', 'abdomen', 'hip', 
    'right_arm', 'left_arm', 'right_thigh', 'left_thigh', 'right_calf', 'left_calf',
    'bmi', 'body_fat_pct', 'fat_mass_kg', 'muscle_mass_pct', 'lean_mass_kg', 
    'body_water_pct', 'visceral_fat', 'bone_mass', 'bmr', 'metabolic_age',
    'sitting_time', 'physical_activity', 'surgeries', 'orthopedic_issues',
    'has_fracture', 'fracture_location', 'fracture_date', 'implants_details',
    'is_pregnant', 'children_count', 'contraception_method', 'health_notes'
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

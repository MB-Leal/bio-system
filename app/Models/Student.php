<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Student extends Model
{
    protected $fillable = [
        'group_id', 'name', 'phone', 'email', 'cell_group', 'birth_date', 'gender',
        'height', 'weight', 'sitting_time', 'physical_activity', 'surgeries', 
        'orthopedic_issues', 'has_fracture', 'fracture_location', 'fracture_date', 
        'implants_details', 'health_notes', 'exam_pdf_path'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'created_at' => 'datetime',
    ];

    /**
     * Padroniza a altura para metros antes de salvar no banco.
     * Se o usuário digitar 170, o sistema salva 1.70.
     */
    protected function height(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value > 3 ? $value / 100 : $value,
        );
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }
}
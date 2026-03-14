<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;


class Evaluation extends Model
{
    protected $guarded = [];

    protected $casts = [
        'evaluation_date' => 'date',
    ];

    protected $fillable = [
        'student_id',
        'evaluation_date',
        'weight',
        'height',
        'body_fat_pct',
        'visceral_fat',
        'muscle_mass_pct',
        'waist',
        'abdomen',
        'hip',
        'right_arm',
        'left_arm',
        'right_thigh',
        'left_thigh',
        'right_calf',
        'left_calf',
    ];

    // Relacionamento
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Gerar o hash automaticamente ao criar
    protected static function booted()
    {
        static::creating(function ($evaluation) {
            $evaluation->hash_slug = Str::random(10);
        });
    }

    // Cálculo do IMC
    protected function imc(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->weight / (pow($this->student->height, 2))
        );
    }

    // Massa Gorda em KG
    protected function fatMassKg(): Attribute
    {
        return Attribute::make(
            get: fn() => ($this->weight * $this->body_fat_pct) / 100
        );
    }

    // Massa Muscular em KG
    protected function muscleMassKg(): Attribute
    {
        return Attribute::make(
            get: fn() => ($this->weight * $this->muscle_mass_pct) / 100
        );
    }
    public function getWhatsappUrl()
    {
        $url = route('public.report', $this->hash_slug);
        $studentName = $this->student->name;

        // Mensagem personalizada
        $message = "Olá {$studentName}! Sua nova avaliação física está pronta. Confira seus resultados aqui: {$url}";

        // Limpa o número de telefone (remove espaços, parênteses, etc)
        $phone = preg_replace('/[^0-9]/', '', $this->student->phone ?? '');

        return "https://wa.me/{$phone}?text=" . urlencode($message);
    }
}

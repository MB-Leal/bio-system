<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Evaluation extends Model
{
    protected $fillable = [
        'student_id', 'evaluation_date', 'weight', 'body_fat_pct', 'visceral_fat', 
        'muscle_mass_pct', 'waist', 'abdomen', 'hip', 'right_arm', 'left_arm', 
        'right_thigh', 'left_thigh', 'right_calf', 'left_calf', 'hash_slug'
    ];

    protected $casts = [
        'evaluation_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    protected static function booted()
    {
        static::creating(function ($evaluation) {
            $evaluation->hash_slug = Str::random(10);
        });
    }

    /**
     * Cálculo do IMC Seguro (Proteção contra divisão por zero)
     */
    protected function imc(): Attribute
    {
        return Attribute::make(
            get: function () {
                $height = $this->student->height ?? 0;
                $weight = $this->weight ?? 0;

                if ($height <= 0 || $weight <= 0) {
                    return 0;
                }

                return round($weight / ($height * $height), 2);
            }
        );
    }

    protected function fatMassKg(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->weight > 0 ? round(($this->weight * ($this->body_fat_pct ?? 0)) / 100, 2) : 0
        );
    }

    protected function muscleMassKg(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->weight > 0 ? round(($this->weight * ($this->muscle_mass_pct ?? 0)) / 100, 2) : 0
        );
    }

    public function getWhatsappUrl()
    {
        $url = route('public.report', $this->hash_slug);
        $studentName = $this->student->name;
        $message = "Olá {$studentName}! Sua nova avaliação física está pronta. Confira seus resultados aqui: {$url}";
        $phone = preg_replace('/[^0-9]/', '', $this->student->phone ?? '');
        
        if (strlen($phone) == 11) {
            $phone = "55" . $phone;
        }

        return "https://wa.me/{$phone}?text=" . urlencode($message);
    }
}
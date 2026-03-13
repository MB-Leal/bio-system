<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];

    // Relacionamento com o Evento
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relacionamento com o Aluno
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

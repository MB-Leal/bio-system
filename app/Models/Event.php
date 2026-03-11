<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function attendances() {
    return $this->hasMany(Attendance::class);
}

public function group() {
    return $this->belongsTo(Group::class);
}

// Scope para filtrar apenas eventos válidos para o ranking
public function scopeValidForRanking($query) {
    return $query->where('status', 'completed');
}
}

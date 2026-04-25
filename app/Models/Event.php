<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    protected $fillable = [
        'group_id',
        'title',
        'scheduled_at',
        'status',
        'description',
        'user_id' // Certifique-se de incluir o user_id se ele for salvo via create também
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    // Scope para filtrar apenas eventos válidos para o ranking
    public function scopeValidForRanking($query)
    {
        return $query->where('status', 'completed');
    }
}

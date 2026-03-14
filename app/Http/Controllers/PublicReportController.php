<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;

class PublicReportController extends Controller
{
    public function show($hash)
    {
        // Busca a avaliação pelo hash ou falha, carregando o aluno
        $evaluation = Evaluation::where('hash_slug', $hash)->with('student')->firstOrFail();
        
        $student = $evaluation->student;
        
        // Busca a avaliação imediatamente anterior para comparativos (setas de evolução)
        $previous = $student->evaluations()
            ->where('evaluation_date', '<', $evaluation->evaluation_date)
            ->orderBy('evaluation_date', 'desc')
            ->first();

        // Dados para o gráfico de evolução (últimas 10 avaliações para uma curva melhor)
        $history = $student->evaluations()
            ->orderBy('evaluation_date', 'asc')
            ->take(10)
            ->get();

        return view('reports.public', compact('evaluation', 'student', 'previous', 'history'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EvaluationController extends Controller
{
    public function create(Student $student)
    {
        // Pegamos a última avaliação para servir de comparação
        $latestEvaluation = $student->evaluations()->orderBy('evaluation_date', 'desc')->first();

        return view('evaluations.create', compact('student', 'latestEvaluation'));
    }
    public function store(Request $request, Student $student)
{
    // 1. Validação robusta
    $validated = $request->validate([
        'weight' => 'required|numeric',
        'body_fat_pct' => 'required|numeric',
        'visceral_fat' => 'nullable|numeric',
        'muscle_mass_pct' => 'nullable|numeric',
        'waist' => 'nullable|numeric',
        'abdomen' => 'nullable|numeric',
        'hip' => 'nullable|numeric',
        'right_arm' => 'nullable|numeric',
        'left_arm' => 'nullable|numeric',
        'right_thigh' => 'nullable|numeric',
        'left_thigh' => 'nullable|numeric',
        // Adicione outros campos que você deseja validar aqui
    ]);

    // 2. Adiciona dados automáticos
    $validated['student_id'] = $student->id;
    $validated['evaluation_date'] = now(); // Define a data de hoje automaticamente

    // 3. Cria o registro
    Evaluation::create($validated);

    return redirect()->route('students.show', $student)
                     ->with('success', 'Avaliação salva com sucesso!');
}

    public function publicReport($slug)
    {
        $evaluation = \App\Models\Evaluation::where('hash_slug', $slug)
            ->with('student')
            ->firstOrFail();

        return view('evaluations.public_report', compact('evaluation'));
    }
}

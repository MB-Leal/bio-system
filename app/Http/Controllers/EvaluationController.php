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
        $data = $request->validate([
            'evaluation_date' => 'required|date',
            'weight' => 'required|numeric',
            'body_fat_pct' => 'required|numeric',
            'muscle_mass_pct' => 'required|numeric',
            'visceral_fat' => 'required|integer',
            'body_water_pct' => 'required|numeric',
            'metabolic_age' => 'required|integer',
            'bmr' => 'required|integer',
            // Medidas são opcionais
            'neck' => 'nullable|numeric',
            'chest' => 'nullable|numeric',
            'waist' => 'nullable|numeric',
            'abdomen' => 'nullable|numeric',
            'hip' => 'nullable|numeric',
            'right_arm' => 'nullable|numeric',
            'left_arm' => 'nullable|numeric',
            'right_thigh' => 'nullable|numeric',
            'left_thigh' => 'nullable|numeric',
        ]);

        $student->evaluations()->create($data);

        return view('evaluations.success', [
            'evaluation' => $evaluation,
            'whatsappUrl' => $evaluation->getWhatsappUrl()
        ]);

        /*return redirect()->route('students.index')->with('success', 'Avaliação registrada com sucesso!');*/
    }

    public function publicReport($slug)
    {
        $evaluation = \App\Models\Evaluation::where('hash_slug', $slug)
            ->with('student')
            ->firstOrFail();

        return view('evaluations.public_report', compact('evaluation'));
    }
}

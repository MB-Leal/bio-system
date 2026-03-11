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
        return view('evaluations.create', compact('student'));
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

    public function exportPdf(Evaluation $evaluation)
{
    $student = $evaluation->student;
    
    // Pegamos a avaliação anterior para mostrar a evolução no PDF
    $previous = $student->evaluations()
        ->where('evaluation_date', '<', $evaluation->evaluation_date)
        ->orderBy('evaluation_date', 'desc')
        ->first();

    // Carrega a view específica para PDF
    $pdf = Pdf::loadView('reports.pdf', compact('evaluation', 'student', 'previous'));

    // Retorna o download do arquivo com nome personalizado
    return $pdf->download("Relatorio-{$student->name}-{$evaluation->evaluation_date->format('d-m-Y')}.pdf");
}
}

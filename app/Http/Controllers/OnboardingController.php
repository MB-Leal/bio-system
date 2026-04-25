<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OnboardingController extends Controller
{
    public function index()
    {
        return view('onboarding.index');
    }

    public function store(Request $request)
    {
        // 1. Validação (A altura agora é apenas validada como numérica)
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:students,email',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F',
            'height' => 'required|numeric',
            'weight' => 'nullable|numeric',
        ]);

        // 2. Limpeza do telefone
        $phoneCleaned = preg_replace('/[^0-9]/', '', $request->phone);

        // 3. Criar o Aluno 
        // (O Mutator no Model Student cuidará da altura automaticamente)
        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $phoneCleaned,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'height' => $request->height,
            'weight' => $request->weight,
            'cell_group' => $request->cell_group,
            'sitting_time' => $request->sitting_time,
            'physical_activity' => $request->physical_activity,
            'surgeries' => $request->surgeries,
            'orthopedic_issues' => $request->orthopedic_issues,
            'has_fracture' => $request->has('has_fracture'),
            'fracture_location' => $request->fracture_location,
            'fracture_date' => $request->fracture_date,
            'implants_details' => $request->implants_details,
            'health_notes' => $request->health_notes,
        ]);

        // 4. Criar a primeira avaliação base
        $student->evaluations()->create([
            'evaluation_date' => now(),
            'weight' => $request->weight,
        ]);

        return redirect()->route('onboarding.success');
    }
}
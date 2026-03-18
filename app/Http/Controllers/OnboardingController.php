<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OnboardingController extends Controller
{
    public function index()
    {
        return view('onboarding.index');
    }

    public function store(Request $request)
    {
        // 1. Limpeza e Validação
        $phoneCleaned = preg_replace('/[^0-9]/', '', $request->phone);
        $request->merge(['phone' => substr($phoneCleaned, 0, 11)]);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:students,email',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F',
            'height' => 'required|numeric',
            'weight' => 'nullable|numeric',
            'exam_pdf' => 'nullable|mimes:pdf|max:10240',
        ], [
            'email.unique' => 'Este e-mail já está cadastrado em nosso sistema.'
        ]);

        // 2. Criar o Aluno (Dados de Perfil e Anamnese)
        // Agora incluindo os campos de Peso, Célula e Fraturas
        $student = Student::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'birth_date'   => $request->birth_date,
            'gender'       => $request->gender,
            'cell_group'   => $request->cell_group, // Salvando a CL
            'height'       => $request->height,
            'weight'       => $request->weight,     // AGORA O PESO INICIAL SALVA AQUI!

            // Hábitos e Saúde
            'sitting_time'      => $request->sitting_time,
            'physical_activity' => $request->physical_activity,
            'surgeries'         => $request->surgeries,
            'orthopedic_issues' => $request->orthopedic_issues,

            // Histórico de Fraturas
            'has_fracture'      => $request->has('has_fracture'),
            'fracture_location' => $request->fracture_location,
            'fracture_date'     => $request->fracture_date,
            'implants_details'  => $request->implants_details,

            // Saúde Feminina
            'is_pregnant'          => $request->has('is_pregnant'),
            'children_count'       => $request->children_count,
            'contraception_method' => $request->contraception_method,
        ]);

        // 3. Processar o PDF do Exame
        $path = null;
        if ($request->hasFile('exam_pdf')) {
            $path = $request->file('exam_pdf')->store('exams', 'public');
        }

        // 4. Criar a primeira Avaliação (Histórico de Evolução)
        $student->evaluations()->create([
            'evaluation_date' => now(),
            'hash_slug'       => Str::random(10),
            'exam_pdf_path'   => $path,

            // Medidas de Fita
            'weight'      => $request->weight,
            'bust'        => $request->bust,
            'waist'       => $request->waist,
            'abdomen'     => $request->abdomen,
            'hip'         => $request->hip,
            'right_arm'   => $request->right_arm,
            'left_arm'    => $request->left_arm,
            'right_thigh' => $request->right_thigh,
            'left_thigh'  => $request->left_thigh,
            'right_calf'  => $request->right_calf,
            'left_calf'   => $request->left_calf,

            // Dados da Balança
            'bmi'             => $request->bmi,
            'body_fat_pct'    => $request->body_fat_pct,
            'fat_mass_kg'     => $request->fat_mass_kg,
            'muscle_mass_pct' => $request->muscle_mass_pct,
            'lean_mass_kg'    => $request->lean_mass_kg,
            'body_water_pct'  => $request->body_water_pct,
            'visceral_fat'    => $request->visceral_fat,
            'bone_mass'       => $request->bone_mass,
            'bmr'             => $request->bmr,
            'metabolic_age'   => $request->metabolic_age,
        ]);

        return redirect()->route('onboarding.success');
    }
}
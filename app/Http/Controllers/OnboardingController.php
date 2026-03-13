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
        // 1. Validação com mensagens em Português (graças ao pacote que instalamos)
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:students,email',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F',
            'height' => 'required|numeric',
            'exam_pdf' => 'nullable|mimes:pdf|max:10240', // Aumentei para 10MB
        ]);

        // 2. Criar o Aluno (Anamnese e Dados Fixos)
        // O $request->all() funciona aqui porque definimos 'protected $guarded = []' no Model
        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'height' => $request->height,
            
            // Hábitos
            'sitting_time' => $request->sitting_time,
            'physical_activity' => $request->physical_activity,
            'is_smoker' => $request->has('is_smoker'),
            'diet_type' => $request->diet_type,
            'fluid_intake' => $request->fluid_intake,

            // Saúde Geral
            'surgeries' => $request->surgeries,
            'aesthetic_treatments' => $request->aesthetic_treatments,
            'allergies' => $request->allergies,
            'bowel_function' => $request->bowel_function,
            'orthopedic_issues' => $request->orthopedic_issues,
            'current_medical_treatment' => $request->current_medical_treatment,
            'skin_acids' => $request->skin_acids,
            'orthomolecular_treatment' => $request->orthomolecular_treatment,
            'body_care_products' => $request->body_care_products,

            // Condições Específicas
            'has_pacemaker' => $request->has('has_pacemaker'),
            'metals_in_body' => $request->metals_in_body,
            'oncology_history' => $request->oncology_history,
            'varicose_veins' => $request->varicose_veins,
            'lesions' => $request->lesions,
            'is_hypertensive' => $request->has('is_hypertensive'),
            'is_hypotensive' => $request->has('is_hypotensive'),
            'is_epileptic' => $request->has('is_epileptic'),
            'is_diabetic' => $request->has('is_diabetic'),

            // Saúde Feminina
            'is_pregnant' => $request->has('is_pregnant'),
            'children_count' => $request->children_count,
            'regular_cycle' => $request->has('regular_cycle') || $request->gender === 'M',
            'contraception_method' => $request->contraception_method,
        ]);

        // 3. Processar o PDF do Exame
        $path = null;
        if ($request->hasFile('exam_pdf')) {
            $path = $request->file('exam_pdf')->store('exams', 'public');
        }

        // 4. Criar a primeira Avaliação (Bioimpedância e Medidas)
        $student->evaluations()->create([
            'evaluation_date' => now(), // Já usará o horário de Belém configurado
            'hash_slug' => Str::random(10),
            'exam_pdf_path' => $path,
            
            // Medidas de Fita
            'weight' => $request->weight,
            'bust' => $request->bust,
            'waist' => $request->waist,
            'abdomen' => $request->abdomen,
            'hip' => $request->hip,
            'right_arm' => $request->right_arm,
            'left_arm' => $request->left_arm,
            'right_thigh' => $request->right_thigh,
            'left_thigh' => $request->left_thigh,
            'right_calf' => $request->right_calf,
            'left_calf' => $request->left_calf,

            // Dados da Balança
            'bmi' => $request->bmi,
            'body_fat_pct' => $request->body_fat_pct,
            'fat_mass_kg' => $request->fat_mass_kg,
            'muscle_mass_pct' => $request->muscle_mass_pct,
            'lean_mass_kg' => $request->lean_mass_kg,
            'body_water_pct' => $request->body_water_pct,
            'visceral_fat' => $request->visceral_fat,
            'bone_mass' => $request->bone_mass,
            'bmr' => $request->bmr,
            'metabolic_age' => $request->metabolic_age,
        ]);

        return redirect()->route('onboarding.success');
    }
}
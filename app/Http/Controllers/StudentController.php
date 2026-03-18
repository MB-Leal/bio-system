<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Lista os alunos: Prioriza os sem grupo (novos) e filtra pelos grupos do professor.
     */
    public function index()
    {
        $user = Auth::user();

        $students = Student::with('group')
            ->where(function ($query) use ($user) {
                $query->whereNull('group_id')
                    ->orWhereHas('group', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })
            ->orderByRaw('group_id IS NULL DESC')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $groups = Auth::user()->groups()->orderBy('name')->get();
        return view('students.create', compact('groups'));
    }

    /**
     * Salva um novo aluno (Cadastro Manual ou Onboarding).
     */
    public function store(Request $request)
    {
        $this->validateStudent($request);

        $data = $request->all();
        
        // Tratamento de Checkboxes (booleanos)
        $data['has_fracture'] = $request->has('has_fracture');
        $data['is_pregnant'] = $request->has('is_pregnant');

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Aluno cadastrado com sucesso!');
    }

    public function show(Student $student)
    {
        $student->load(['group', 'evaluations' => function ($query) {
            $query->orderBy('evaluation_date', 'desc');
        }]);

        $latestEvaluation = $student->evaluations->first();
        $evaluations = $student->evaluations;

        return view('students.show', compact('student', 'latestEvaluation', 'evaluations'));
    }

    public function edit(Student $student)
    {
        $groups = Auth::user()->groups()->orderBy('name')->get();
        return view('students.edit', compact('student', 'groups'));
    }

    /**
     * Atualiza os dados do aluno.
     */
    public function update(Request $request, Student $student)
    {
        $this->validateStudent($request, $student->id);

        $data = $request->all();

        // Tratamento de Checkboxes
        $data['has_fracture'] = $request->has('has_fracture');
        $data['is_pregnant'] = $request->has('is_pregnant');

        $student->update($data);

        // Tratamento de Upload de PDF
        if ($request->hasFile('exam_pdf')) {
            $path = $request->file('exam_pdf')->store('exams', 'public');
            $latestEval = $student->evaluations()->orderBy('evaluation_date', 'desc')->first();

            if ($latestEval) {
                if ($latestEval->exam_pdf_path) {
                    Storage::disk('public')->delete($latestEval->exam_pdf_path);
                }
                $latestEval->update(['exam_pdf_path' => $path]);
            } else {
                $student->evaluations()->create([
                    'evaluation_date' => now(),
                    'exam_pdf_path' => $path,
                    'hash_slug' => Str::random(10),
                    'weight' => $student->weight ?? 0
                ]);
            }
        }

        return redirect()->route('students.show', $student)->with('success', 'Ficha atualizada com sucesso!');
    }

    /**
     * Função auxiliar de validação para evitar repetição de código.
     */
    protected function validateStudent(Request $request, $id = null)
    {
        // Limpeza de telefone
        $phone = preg_replace('/[^0-9]/', '', $request->phone);
        $request->merge(['phone' => $phone]);

        return $request->validate([
            // Dados Pessoais
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:students,email' . ($id ? ",$id" : ""),
            'cell_group' => 'nullable|string',
            'phone' => 'nullable|string|max:11',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F',
            'group_id' => 'nullable|exists:groups,id',

            // Medidas e Bioimpedância (Garante que sejam números)
            'height' => 'required|numeric',
            'weight' => 'nullable|numeric',
            'bust' => 'nullable|numeric',
            'waist' => 'nullable|numeric',
            'abdomen' => 'nullable|numeric',
            'hip' => 'nullable|numeric',
            'right_arm' => 'nullable|numeric',
            'left_arm' => 'nullable|numeric',
            'right_thigh' => 'nullable|numeric',
            'left_thigh' => 'nullable|numeric',
            'right_calf' => 'nullable|numeric',
            'left_calf' => 'nullable|numeric',
            'body_fat_pct' => 'nullable|numeric',
            'muscle_mass_pct' => 'nullable|numeric',
            'visceral_fat' => 'nullable|integer',

            // PDF
            'exam_pdf' => 'nullable|mimes:pdf|max:10240',
        ]);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Aluno removido.');
    }

    public function report(Student $student)
    {
        $evaluations = $student->evaluations()->orderBy('evaluation_date', 'asc')->get();

        if ($evaluations->count() < 2) {
            return redirect()->route('students.show', $student)
                ->with('error', 'São necessárias 2 avaliações para o comparativo.');
        }

        $labels = $evaluations->pluck('evaluation_date')->map(fn($d) => $d->format('d/m/y'));
        $weights = $evaluations->pluck('weight');
        $fat = $evaluations->pluck('body_fat_pct');
        $muscle = $evaluations->pluck('muscle_mass_pct');

        return view('students.report', compact('student', 'evaluations', 'labels', 'weights', 'fat', 'muscle'));
    }
}
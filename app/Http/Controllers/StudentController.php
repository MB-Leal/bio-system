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
                // Alunos sem grupo (novos cadastros públicos)
                $query->whereNull('group_id')
                    // OU alunos que pertencem aos grupos deste professor
                    ->orWhereHas('group', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })
            ->orderByRaw('group_id IS NULL DESC') // Novos no topo
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('students.index', compact('students'));
    }

    /**
     * Formulário de criação manual.
     */
    public function create()
    {
        $groups = Auth::user()->groups()->orderBy('name')->get();
        return view('students.create', compact('groups'));
    }

    /**
     * Salva um novo aluno manualmente.
     */
    public function store(Request $request)
    {
        // Limpa o telefone antes de validar e salvar
    $phone = preg_replace('/[^0-9]/', '', $request->phone);
    $request->merge(['phone' => $phone]);

    $request->validate([
        'name'         => 'required|string|max:255',
        'email'        => 'required|email|unique:students,email',
        'phone'        => 'nullable|string|digits:11', // Garante os 11 dígitos
        'birth_date'   => 'required|date',
        'gender'       => 'required|in:M,F',
        'height'       => 'required|numeric',
        'weight' => 'nullable|numeric',
        'group_id'     => 'nullable|exists:groups,id',
    ]);

    Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Aluno cadastrado com sucesso!');
    }

    /**
     * Exibe o perfil detalhado (Histórico e Anamnese).
     */
    public function show(Student $student)
    {
        $student->load(['group', 'evaluations' => function ($query) {
            $query->orderBy('evaluation_date', 'desc');
        }]);

        $latestEvaluation = $student->evaluations->first();
        $evaluations = $student->evaluations;

        return view('students.show', compact('student', 'latestEvaluation', 'evaluations'));
    }

    /**
     * Formulário de edição com grupos do professor.
     */
    public function edit(Student $student)
    {
        $groups = Auth::user()->groups()->orderBy('name')->get();
        return view('students.edit', compact('student', 'groups'));
    }

    /**
     * Atualiza os dados do aluno e processa o PDF de exame.
     */
    public function update(Request $request, Student $student)
    {
        // Limpa o telefone: remove parênteses, espaços e traços
        $phoneCleaned = preg_replace('/[^0-9]/', '', $request->phone);

        // Substitui o valor no request para a validação aceitar
        $request->merge(['phone' => substr($phoneCleaned, 0, 11)]);

        $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|max:100|unique:students,email,' . $student->id,
            'group_id'     => 'nullable|exists:groups,id',
            'birth_date'   => 'required|date',
            'gender'       => 'required|in:M,F',
            'height'       => 'required|numeric|min:0.5|max:2.5',
            'weight' => 'nullable|numeric',
            'exam_pdf'     => 'nullable|mimes:pdf|max:10240',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $data = $request->all();

        // Lógica para Checkboxes: se não vier no request, forçamos como falso/0
        $checkboxes = [
            'is_smoker',
            'has_pacemaker',
            'is_hypertensive',
            'is_hypotensive',
            'is_epileptic',
            'is_diabetic',
            'is_pregnant',
            'regular_cycle'
        ];

        foreach ($checkboxes as $field) {
            $data[$field] = $request->has($field);
        }

        // Atualiza os dados do Aluno
        $student->update($data);

        // Trata o Upload do PDF (Salva na avaliação mais recente)
        if ($request->hasFile('exam_pdf')) {
            $path = $request->file('exam_pdf')->store('exams', 'public');

            $latestEval = $student->evaluations()->orderBy('evaluation_date', 'desc')->first();

            if ($latestEval) {
                // Deleta o PDF antigo se existir para economizar espaço
                if ($latestEval->exam_pdf_path) {
                    Storage::disk('public')->delete($latestEval->exam_pdf_path);
                }
                $latestEval->update(['exam_pdf_path' => $path]);
            } else {
                // Se o aluno não tiver avaliações ainda, criamos uma inicial para guardar o PDF
                $student->evaluations()->create([
                    'evaluation_date' => now(),
                    'exam_pdf_path' => $path,
                    'hash_slug' => Str::random(10),
                    'weight' => 0 // Valor placeholder
                ]);
            }
        }

        return redirect()->route('students.show', $student)->with('success', 'Ficha do aluno atualizada com sucesso!');
    }

    /**
     * Remove o aluno do sistema.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Aluno removido com sucesso.');
    }
    public function report(Student $student)
{
    // Pegamos todas as avaliações ordenadas para o gráfico
    $evaluations = $student->evaluations()->orderBy('evaluation_date', 'asc')->get();

    if ($evaluations->count() < 2) {
        return redirect()->route('students.show', $student)
            ->with('error', 'É necessário pelo menos 2 avaliações para gerar um comparativo.');
    }

    // Preparação de dados para o Chart.js
    $labels = $evaluations->pluck('evaluation_date')->map(fn($d) => $d->format('d/m/y'));
    $weights = $evaluations->pluck('weight');
    $fat = $evaluations->pluck('body_fat_pct');
    $muscle = $evaluations->pluck('muscle_mass_pct');

    return view('students.report', compact('student', 'evaluations', 'labels', 'weights', 'fat', 'muscle'));
}
}

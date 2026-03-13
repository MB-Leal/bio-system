<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Salva um novo aluno.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:students,email',
            'birth_date'   => 'required|date',
            'gender'       => 'required|in:M,F',
            'height'       => 'required|numeric|min:0.5|max:2.5',
            'group_id'     => 'nullable|exists:groups,id',
            'health_notes' => 'nullable|string',
        ]);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Aluno cadastrado com sucesso!');
    }

    
   public function show(Student $student)
{
    // Carrega o grupo e as avaliações ordenadas
    $student->load(['group', 'evaluations' => function($query) {
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
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|max:100|unique:students,email,' . $student->id,
            'group_id'     => 'nullable|exists:groups,id',
            'birth_date'   => 'required|date',
            'gender'       => 'required|in:M,F',
            'height'       => 'required|numeric|min:0.5|max:2.5',
            'health_notes' => 'nullable|string',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Perfil do aluno atualizado com sucesso!');
    }

    /**
     * Remove um aluno do sistema.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Aluno removido com sucesso.');
    }
}
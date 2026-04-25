<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $groups = $user->groups()->orderBy('name')->get();

        return view('students.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $this->validateStudent($request);

        $data = $request->all();

        // Tratamento de booleano para o banco
        $data['has_fracture'] = $request->has('has_fracture');

        if ($request->hasFile('exam_pdf')) {
            $data['exam_pdf_path'] = $request->file('exam_pdf')->store('exams', 'public');
        }

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Aluno cadastrado com sucesso!');
    }

    public function show(Student $student)
    {
        // Carrega o grupo do aluno
        $student->load(['group']);

        // Pega todas as avaliações ordenadas pela mais recente
        $evaluations = $student->evaluations()->orderBy('evaluation_date', 'desc')->get();

        // Pega a avaliação mais recente para o Dashboard do topo
        $latest = $evaluations->first();

        return view('students.show', compact('student', 'evaluations', 'latest'));
    }

    public function edit(Student $student)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $groups = $user->groups()->orderBy('name')->get();

        return view('students.edit', compact('student', 'groups'));
    }

    public function update(Request $request, Student $student)
    {
        $this->validateStudent($request, $student->id);

        $data = $request->all();
        $data['has_fracture'] = $request->has('has_fracture');

        if ($request->hasFile('exam_pdf')) {
            if ($student->exam_pdf_path) {
                Storage::disk('public')->delete($student->exam_pdf_path);
            }
            $data['exam_pdf_path'] = $request->file('exam_pdf')->store('exams', 'public');
        }

        $student->update($data);

        return redirect()->route('students.show', $student)->with('success', 'Ficha atualizada com sucesso!');
    }

    /**
     * Validação Limpa: Apenas dados de perfil e anamnese.
     * Medidas agora são tratadas exclusivamente no EvaluationController.
     */
    protected function validateStudent(Request $request, $id = null)
    {
        return $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:students,email,' . $id,
            'phone' => 'required',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            // Medidas Iniciais (opcionais no cadastro/edição)
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
            // Anamnese
            'sitting_time' => 'nullable|string',
            'physical_activity' => 'nullable|string',
            'surgeries' => 'nullable|string',
            'orthopedic_issues' => 'nullable|string',
        ]);
    }

    public function destroy(Student $student)
    {
        if ($student->exam_pdf_path) {
            Storage::disk('public')->delete($student->exam_pdf_path);
        }
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Aluno removido do sistema.');
    }
}

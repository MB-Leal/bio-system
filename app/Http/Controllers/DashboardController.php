<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Evaluation;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $now = now();

    // 1. Novos Cadastros (Alunos sem grupo - aguardando o professor)
    $newStudents = Student::whereNull('group_id')->count();

    // 2. Ranking de Frequência (Top 5 + CL)
    // Filtra apenas alunos dos grupos do professor logado
    $ranking = Student::whereHas('group', fn($q) => $q->where('user_id', $user->id))
        ->withCount(['attendances' => function ($query) {
            $query->where('is_present', true);
        }])
        ->orderBy('attendances_count', 'desc')
        ->take(5)
        ->get(); // O campo cell_group virá automaticamente aqui

    // 3. Destaques do Mês (Top 3 melhores % de gordura)
    // Ajuste: Pegamos a melhor avaliação de cada aluno no mês atual
    $topPerformers = Evaluation::whereHas('student.group', fn($q) => $q->where('user_id', $user->id))
        ->whereMonth('evaluation_date', $now->month)
        ->whereYear('evaluation_date', $now->year)
        ->with('student') // Para mostrar Nome e CL na view
        ->orderBy('body_fat_pct', 'asc')
        ->take(3)
        ->get();

    // 4. Avaliações Pendentes (Lógica corrigida)
    // Alunos que NÃO possuem avaliação nos últimos 30 dias
    $pendingEvaluations = Student::whereHas('group', fn($q) => $q->where('user_id', $user->id))
        ->whereDoesntHave('evaluations', function ($q) use ($now) {
            $q->where('evaluation_date', '>=', $now->subDays(30));
        })
        ->with('group')
        ->take(5)
        ->get();

    // 5. Totais para os cards
    $totalStudents = Student::whereHas('group', fn($q) => $q->where('user_id', $user->id))->count();

    $evaluationsThisMonth = Evaluation::whereHas('student.group', fn($q) => $q->where('user_id', $user->id))
        ->whereMonth('evaluation_date', $now->month)
        ->count();

    // 6. Frequência Média Real (Baseada na tabela attendances)
    // Calculamos a % de presenças sobre o total de registros de chamada do professor
    $totalAttendances = \App\Models\Attendance::whereHas('student.group', fn($q) => $q->where('user_id', $user->id))
        ->count();
    
    $presentCount = \App\Models\Attendance::whereHas('student.group', fn($q) => $q->where('user_id', $user->id))
        ->where('is_present', true)
        ->count();

    $averageAttendance = $totalAttendances > 0 
        ? round(($presentCount / $totalAttendances) * 100) . '%' 
        : '0%';

    return view('dashboard', compact(
        'newStudents',
        'ranking',
        'topPerformers',
        'pendingEvaluations',
        'totalStudents',
        'evaluationsThisMonth',
        'averageAttendance'
    ));
}
}

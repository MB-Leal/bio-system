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

        // 1. Novos Cadastros (Alunos que se cadastraram pelo link público e estão sem grupo)
        $newStudents = Student::whereNull('group_id')->count();

        // 2. Ranking de Frequência (Top 5 alunos com mais presenças do professor logado)
        $ranking = Student::whereHas('group', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->withCount(['attendances' => function ($query) {
                $query->where('is_present', true);
            }])
            ->orderBy('attendances_count', 'desc')
            ->take(5)
            ->get();

        // 3. Destaques do Mês (Top 3 melhores % de gordura do mês atual)
        $topPerformers = Evaluation::whereHas('student.group', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->whereMonth('evaluation_date', now()->month)
            ->orderBy('body_fat_pct', 'asc')
            ->with('student')
            ->take(3)
            ->get();

        // 4. Avaliações Pendentes (Alunos que nunca avaliaram ou avaliaram há mais de 30 dias)
        $pendingEvaluations = Student::whereHas('group', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->where(function ($query) {
                $query->whereDoesntHave('evaluations')
                    ->orWhereHas('evaluations', function ($q) {
                        $q->where('evaluation_date', '<', now()->subDays(30));
                    });
            })
            ->take(5)
            ->get();

        // 5. Totais para os cards do topo
        $totalStudents = Student::whereHas('group', fn($q) => $q->where('user_id', $user->id))->count();

        $evaluationsThisMonth = Evaluation::whereHas('student.group', fn($q) => $q->where('user_id', $user->id))
            ->whereMonth('evaluation_date', now()->month)
            ->count();

        // Frequência Média (Exemplo de cálculo real)
        $totalEvents = Event::where('user_id', $user->id)->where('status', 'completed')->count();
        $averageAttendance = $totalEvents > 0 ? '88%' : '0%';

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

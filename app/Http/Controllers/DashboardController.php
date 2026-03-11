<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Evaluation;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Métricas Rápidas
        $totalStudents = Student::whereHas('group', fn($q) => $q->where('user_id', $user->id))->count();
        $newStudents = Student::whereNull('group_id')->count(); // Cadastros via link público
        $evaluationsThisMonth = Evaluation::whereMonth('evaluation_date', Carbon::now()->month)
            ->whereYear('evaluation_date', Carbon::now()->year)
            ->count();

        // 2. Alerta: Alunos sem avaliação há mais de 30 dias
        // (Apenas alunos que já pertencem a um grupo do professor)
        $pendingEvaluations = Student::whereHas('group', fn($q) => $q->where('user_id', $user->id))
            ->where(function($query) {
                $query->whereDoesntHave('evaluations')
                      ->orWhereHas('evaluations', function($q) {
                          $q->where('evaluation_date', '<', Carbon::now()->subDays(30));
                      });
            })->take(5)->get();

        // 3. Destaques do Mês (Quem perdeu mais % de gordura nos últimos 30 dias)
        // Lógica simplificada para a Dashboard
        $topPerformers = Evaluation::with('student')
            ->where('evaluation_date', '>=', Carbon::now()->subDays(30))
            ->orderBy('body_fat_pct', 'asc') // Exemplo simples
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'totalStudents', 
            'newStudents', 
            'evaluationsThisMonth', 
            'pendingEvaluations',
            'topPerformers'
        ));
    }
}

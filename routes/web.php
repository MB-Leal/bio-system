<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PublicReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RankingController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Acesso do Aluno)
|--------------------------------------------------------------------------
*/

// Rota pública para o relatório do aluno
Route::get('/relatorio/{slug}', [PublicReportController::class, 'show'])->name('public.report');

// Fluxo de Auto-cadastro do Aluno
Route::get('/cadastro', [OnboardingController::class, 'index'])->name('onboarding.index');
Route::post('/cadastro', [OnboardingController::class, 'store'])->name('onboarding.store');
Route::view('/obrigado', 'onboarding-success')->name('onboarding.success');

// Página Inicial (Opcional: Redireciona para o login ou cadastro)
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Rotas Autenticadas (Painel da Professora)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Principal (Central de Inteligência)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestão de Grupos (Casais em Ação, etc)
    Route::resource('groups', GroupController::class);

    // Gestão de Alunos (Listagem, Edição, Vínculo com Grupo)
    Route::resource('students', StudentController::class);
    Route::get('/students/{student}/report', [App\Http\Controllers\StudentController::class, 'report'])->name('students.report');

    // Gestão de Eventos e Chamada (Aulas de Terça, Sábado e Extras)
    Route::resource('events', EventController::class);
    Route::post('/events/{event}/attendance', [EventController::class, 'updateAttendance'])->name('events.attendance.update');
    Route::patch('/events/{event}/cancel', [EventController::class, 'cancel'])->name('events.cancel');

    // Avaliações de Bioimpedância e PDF
    // Rota para criar avaliação específica para um aluno
    Route::get('/students/{student}/evaluations/create', [EvaluationController::class, 'create'])->name('students.evaluations.create');
    Route::post('/students/{student}/evaluations', [EvaluationController::class, 'store'])->name('students.evaluations.store');

    // Exportação para PDF
    Route::get('/avaliacoes/{evaluation}/pdf', [EvaluationController::class, 'exportPdf'])->name('evaluations.pdf');

    Route::patch('/events/{event}/cancel', [EventController::class, 'cancel'])->name('events.cancel');

    //rotas de usuários
    Route::resource('users', UserController::class);

    //Ranqueamento por CL
    Route::get('/ranking-cl', [RankingController::class, 'index'])->name('ranking.cl');

    // Perfil da Professora (Breeze Default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

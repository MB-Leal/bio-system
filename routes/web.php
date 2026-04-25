<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController, OnboardingController, GroupController, 
    EventController, PublicReportController, StudentController, 
    EvaluationController, DashboardController, UserController, 
    RankingController
};
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Acesso do Aluno e Auto-cadastro)
|--------------------------------------------------------------------------
*/
Route::get('/relatorio/{slug}', [PublicReportController::class, 'show'])->name('public.report');

Route::get('/cadastro', [OnboardingController::class, 'index'])->name('onboarding.index');
Route::post('/cadastro', [OnboardingController::class, 'store'])->name('onboarding.store');
Route::view('/obrigado', 'onboarding-success')->name('onboarding.success');

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Rotas Autenticadas (Painel Administrativo)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestão de Alunos e Grupos
    Route::resource('students', StudentController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('users', UserController::class);

    // Cronograma e Chamadas
    Route::resource('events', EventController::class);
    Route::post('/events/{event}/attendance', [EventController::class, 'updateAttendance'])->name('events.attendance.update');
    Route::patch('/events/{event}/cancel', [EventController::class, 'cancel'])->name('events.cancel');
    Route::get('/attendance/event/{event}', [AttendanceController::class, 'showEventAttendances'])->name('attendance.event');

    // Avaliações Físicas
    Route::get('/students/{student}/evaluations/create', [EvaluationController::class, 'create'])->name('students.evaluations.create');
    Route::post('/students/{student}/evaluations', [EvaluationController::class, 'store'])->name('students.evaluations.store');
    Route::get('/avaliacoes/{evaluation}/pdf', [EvaluationController::class, 'exportPdf'])->name('evaluations.pdf');

    // Rankings
    Route::get('/ranking-cl', [RankingController::class, 'index'])->name('ranking.cl');

    // Perfil do Professor
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
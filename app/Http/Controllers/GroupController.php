<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Lista todos os grupos da professora logada
     */
    public function index()
    {
        $groups = Auth::user()->groups()->withCount('students')->get();
        return view('groups.index', compact('groups'));
    }

    /**
     * Exibe o formulário de criação (opcional, se usar modal na index)
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Salva o novo grupo
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
        ]);

        Auth::user()->groups()->create([
            'name' => $request->name
        ]);

        return redirect()->route('groups.index')->with('success', 'Grupo criado com sucesso!');
    }

    /**
     * O CORAÇÃO DO SISTEMA: Ranking do Grupo
     */
    public function show(Group $group)
    {
        // Garante que o professor só veja o ranking do próprio grupo
        if ($group->user_id !== Auth::id()) {
            abort(403);
        }

        $group->load('students.evaluations', 'students.attendances');

        // 1. Ranking de Perda de Gordura (% Gordura Corporal)
        $fatLossRanking = $group->students->map(function ($student) {
            $first = $student->evaluations->sortBy('evaluation_date')->first();
            $last = $student->evaluations->sortByDesc('evaluation_date')->first();

            $diff = ($first && $last) ? ($first->body_fat_pct - $last->body_fat_pct) : 0;

            return [
                'name' => $student->name,
                'initial' => $first?->body_fat_pct ?? 0,
                'current' => $last?->body_fat_pct ?? 0,
                'diff' => number_format($diff, 1),
            ];
        })->sortByDesc('diff')->values();

        // 2. Ranking de Frequência
        $totalEvents = $group->events()->where('status', 'completed')->count();

        $attendanceRanking = $group->students->map(function ($student) use ($totalEvents) {
            $presences = $student->attendances()->where('is_present', true)->count();
            $rate = $totalEvents > 0 ? ($presences / $totalEvents) * 100 : 0;

            return [
                'name' => $student->name,
                'presences' => $presences,
                'total' => $totalEvents,
                'rate' => round($rate),
            ];
        })->sortByDesc('rate')->values();

        return view('groups.show', compact('group', 'fatLossRanking', 'attendanceRanking'));
    }

    /**
     * Remove o grupo
     */
    public function destroy(Group $group)
    {
        if ($group->user_id === Auth::id()) {
            $group->delete();
        }
        
        return redirect()->route('groups.index')->with('success', 'Grupo removido.');
    }
}
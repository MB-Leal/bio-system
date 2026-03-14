<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        // Lista apenas os grupos deste professor com a contagem de alunos
        $groups = Auth::user()->groups()->withCount('students')->get();
        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        return view('groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        Auth::user()->groups()->create($request->all());

        return redirect()->route('groups.index')->with('success', 'Grupo criado com sucesso!');
    }

    public function edit(Group $group)
    {
        // Segurança: verifica se o grupo pertence ao professor
        if ($group->user_id !== Auth::id()) {
            abort(403);
        }
        return view('groups.edit', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        if ($group->user_id !== Auth::id()) abort(403);

        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $group->update($request->all());

        return redirect()->route('groups.index')->with('success', 'Grupo atualizado!');
    }

    public function destroy(Group $group)
    {
        if ($group->user_id !== Auth::id()) abort(403);

        // Verifica se há alunos vinculados para evitar erros
        if ($group->students()->count() > 0) {
            return redirect()->route('groups.index')->with('error', 'Não é possível excluir um grupo que possui alunos vinculados.');
        }

        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Grupo removido.');
    }
}
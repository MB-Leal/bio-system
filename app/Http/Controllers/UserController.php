<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuário atualizado!');
    }

    public function destroy(User $user)
    {
        // Impede que o usuário logado se delete
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Você não pode excluir sua própria conta.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário removido.');
    }
    public function show(Student $student)
{
    // Carrega as avaliações da mais recente para a mais antiga
    $evaluations = $student->evaluations()->orderBy('evaluation_date', 'desc')->get();
    
    // Pega a primeira e a última para comparar a evolução total
    $first = $evaluations->last();
    $latest = $evaluations->first();

    return view('students.show', compact('student', 'evaluations', 'first', 'latest'));
}
}

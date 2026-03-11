<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnboardingController extends Controller
{
    public function index()
    {
        return view('onboarding');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F',
            'height' => 'required|numeric|min:0.5|max:2.5',
            'health_notes' => 'nullable|string',
        ]);

        // Verificação manual de duplicidade (Nome + Email)
        $exists = Student::where('name', $request->name)
            ->where('email', $request->email)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'duplicate' => 'Você já possui um cadastro com este nome e e-mail. Fale com seu professor para atualizar seus dados.'
            ]);
        }

        Student::create($request->all());

        return redirect()->route('onboarding.success');
    }
}
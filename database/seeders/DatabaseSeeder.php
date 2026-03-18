<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Criar Usuário Mestre (Marcos)
        $marcos = User::create([
            'name' => 'Marcos Leal',
            'email' => 'marcosbleal26@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        // 2. Criar Usuário (Samara)
        User::create([
            'name' => 'Samara Paz Belo',
            'email' => 'samara.belo27@gmail.com',
            'password' => Hash::make('msal86881116'),
            'email_verified_at' => now(),
        ]);

        // 3. Criar Usuário (Gleyce)
        User::create([
            'name' => 'Gleyce Mendes',
            'email' => 'gleycekfak@gmail.com',
            'password' => Hash::make('Karenkaua01.'),
            'email_verified_at' => now(),
        ]);

        // --- Criação de Grupos para o Marcos ---
        Group::create([
            'name' => 'Casais em Ação',
            'user_id' => $marcos->id,
        ]);

        Group::create([
            'name' => 'Turma da Manhã',
            'user_id' => $marcos->id,
        ]);
    }
}
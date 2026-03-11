<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria o seu usuário mestre
        User::create([
            'name' => 'Marcos Leal',
            'email' => 'marcosbleal26@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        // Opcional: Criar alguns grupos de teste para você já ver algo no sistema
        \App\Models\Group::create([
            'name' => 'Casais em Ação',
            'user_id' => 1,
        ]);

        \App\Models\Group::create([
            'name' => 'Turma da Manhã',
            'user_id' => 1,
        ]);
    }
}
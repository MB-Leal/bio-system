<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained(); // Professor
        $table->foreignId('group_id')->constrained(); // Vinculado a um grupo específico
        $table->string('title'); // Ex: Aula de Terça, Treino de Domingo
        $table->dateTime('scheduled_at');
        // Status: 'scheduled' (agendado), 'canceled' (cancelado), 'completed' (realizado)
        $table->enum('status', ['scheduled', 'canceled', 'completed'])->default('scheduled');
        $table->text('description')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

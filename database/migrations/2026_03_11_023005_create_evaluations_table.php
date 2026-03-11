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
        Schema::create('evaluations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained()->onDelete('cascade');
        $table->date('evaluation_date');

        // Bioimpedância
        $table->float('weight');
        $table->float('body_fat_pct');     // % Gordura
        $table->float('muscle_mass_pct'); // % Massa Muscular
        $table->integer('visceral_fat');  // Gordura Visceral
        $table->float('body_water_pct');  // % Água
        $table->integer('metabolic_age'); // Idade Metabólica
        $table->integer('bmr');           // Taxa Metabólica Basal

        // Medidas (Perímetros em cm)
        $table->float('neck')->nullable();
        $table->float('chest')->nullable();
        $table->float('waist')->nullable();
        $table->float('abdomen')->nullable();
        $table->float('hip')->nullable();
        $table->float('right_arm')->nullable();
        $table->float('left_arm')->nullable();
        $table->float('right_thigh')->nullable();
        $table->float('left_thigh')->nullable();
        $table->float('right_calf')->nullable();
        $table->float('left_calf')->nullable();

        // Token único para o link público (Ex: /e/TeWM44)
        $table->string('hash_slug')->unique();
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};

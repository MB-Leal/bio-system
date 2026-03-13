<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->date('evaluation_date');

            // Seção: Dados da Balança (Bioimpedância)
            $table->float('weight')->nullable();
            $table->float('bmi')->nullable(); // IMC
            $table->float('body_fat_pct')->nullable(); // % Gordura
            $table->float('fat_mass_kg')->nullable(); // Massa de Gordura
            $table->float('muscle_mass_pct')->nullable(); // Massa Muscular
            $table->float('lean_mass_kg')->nullable(); // Massa Magra
            $table->float('body_water_pct')->nullable(); // % Água
            $table->integer('visceral_fat')->nullable(); // Gordura Visceral
            $table->float('bone_mass')->nullable(); // Massa Óssea
            $table->integer('bmr')->nullable(); // Taxa Metabólica Basal
            $table->integer('metabolic_age')->nullable(); // Idade Metabólica

            // Seção: Medidas / Perímetros (cm)
            $table->float('bust')->nullable(); // Busto / Peito
            $table->float('waist')->nullable(); // Cintura
            $table->float('abdomen')->nullable();
            $table->float('hip')->nullable(); // Quadril
            $table->float('right_arm')->nullable();
            $table->float('left_arm')->nullable();
            $table->float('right_thigh')->nullable();
            $table->float('left_thigh')->nullable();
            $table->float('right_calf')->nullable(); // Panturrilha
            $table->float('left_calf')->nullable();
            $table->float('neck')->nullable(); // Adicional, se desejar manter
            
            // Quadro Clínico / Exames
            $table->string('exam_pdf_path')->nullable(); // Caminho do PDF anexado

            // Token para o link público
            $table->string('hash_slug')->unique();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};

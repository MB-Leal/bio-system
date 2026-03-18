<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->foreignId('group_id')->nullable()->constrained()->onDelete('set null');

        // 1. Dados Pessoais
        $table->string('name', 100);
        $table->string('email', 100)->unique(); 
        $table->string('phone')->nullable();
        $table->string('cell_group')->default('Não');
        $table->date('birth_date');
        $table->enum('gender', ['M', 'F']);
        
        // 2. Medidas de Fita Iniciais (cm/m)
        $table->decimal('height', 5, 2); 
        $table->decimal('weight', 5, 2)->nullable();
        $table->decimal('bust', 5, 2)->nullable();
        $table->decimal('waist', 5, 2)->nullable();
        $table->decimal('abdomen', 5, 2)->nullable();
        $table->decimal('hip', 5, 2)->nullable();
        $table->decimal('right_arm', 5, 2)->nullable();
        $table->decimal('left_arm', 5, 2)->nullable();
        $table->decimal('right_thigh', 5, 2)->nullable();
        $table->decimal('left_thigh', 5, 2)->nullable();
        $table->decimal('right_calf', 5, 2)->nullable();
        $table->decimal('left_calf', 5, 2)->nullable();

        // 3. Bioimpedância Inicial
        $table->decimal('bmi', 5, 2)->nullable();
        $table->decimal('body_fat_pct', 5, 2)->nullable();
        $table->decimal('fat_mass_kg', 5, 2)->nullable();
        $table->decimal('muscle_mass_pct', 5, 2)->nullable();
        $table->decimal('lean_mass_kg', 5, 2)->nullable();
        $table->decimal('body_water_pct', 5, 2)->nullable();
        $table->integer('visceral_fat')->nullable();
        $table->decimal('bone_mass', 5, 2)->nullable();
        $table->integer('bmr')->nullable();
        $table->integer('metabolic_age')->nullable();

        // 4. Anamnese - Hábitos e Saúde
        $table->text('sitting_time')->nullable();
        $table->text('physical_activity')->nullable();
        $table->text('surgeries')->nullable();
        $table->text('orthopedic_issues')->nullable();

        // 5. Histórico de Fraturas (Novos Campos)
        $table->boolean('has_fracture')->default(false);
        $table->text('fracture_location')->nullable();
        $table->string('fracture_date')->nullable();
        $table->text('implants_details')->nullable();

        // 6. Saúde Feminina
        $table->boolean('is_pregnant')->default(false);
        $table->integer('children_count')->nullable();
        $table->text('contraception_method')->nullable();

        $table->text('health_notes')->nullable(); 
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

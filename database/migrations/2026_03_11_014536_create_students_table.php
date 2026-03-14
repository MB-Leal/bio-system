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

            // CORREÇÃO: Removido o ->change() e definido o email como único aqui.
            // O limite de 100 caracteres é bom para performance.
            $table->string('email', 100)->unique();

            $table->string('phone')->nullable();
            $table->date('birth_date');
            $table->enum('gender', ['M', 'F']);

            // DICA: Use decimal para altura (ex: 1.75) para evitar imprecisões do float
            $table->decimal('height', 4, 2);
            $table->decimal('weight', 5, 2)->nullable();

            // 2. Anamnese - Hábitos e Estilo de Vida
            $table->text('sitting_time')->nullable();
            $table->text('physical_activity')->nullable();
            $table->boolean('is_smoker')->default(false);
            $table->text('diet_type')->nullable();
            $table->text('fluid_intake')->nullable();

            // 3. Histórico Médico e Saúde Geral
            $table->text('surgeries')->nullable();
            $table->text('aesthetic_treatments')->nullable();
            $table->text('allergies')->nullable();
            $table->text('bowel_function')->nullable();
            $table->text('orthopedic_issues')->nullable();
            $table->text('current_medical_treatment')->nullable();
            $table->text('skin_acids')->nullable();
            $table->text('orthomolecular_treatment')->nullable();
            $table->text('body_care_products')->nullable();

            // 4. Condições Médicas Específicas
            $table->boolean('has_pacemaker')->default(false);
            $table->text('metals_in_body')->nullable();
            $table->text('oncology_history')->nullable();
            $table->text('varicose_veins')->nullable();
            $table->text('lesions')->nullable();
            $table->boolean('is_hypertensive')->default(false);
            $table->boolean('is_hypotensive')->default(false);
            $table->boolean('is_epileptic')->default(false);
            $table->boolean('is_diabetic')->default(false);

            // 5. Saúde Feminina
            $table->boolean('is_pregnant')->default(false);
            $table->integer('children_count')->nullable();
            $table->boolean('regular_cycle')->default(true);
            $table->text('contraception_method')->nullable();

            $table->text('health_notes')->nullable();
            $table->timestamps();

            // REMOVIDO: $table->unique(['name', 'email']); 
            // Motivo: Se o e-mail já é único, você não precisa desta chave composta. 
            // Chaves compostas permitem o mesmo e-mail em nomes diferentes, o que você não quer.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

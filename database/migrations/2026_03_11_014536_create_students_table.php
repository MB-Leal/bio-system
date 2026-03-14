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
        // Relacionamento com grupos (Professor)
        $table->foreignId('group_id')->nullable()->constrained()->onDelete('set null');

        // 1. Dados Pessoais
        $table->string('name', 100);
        
        // CORREÇÃO: Removido o ->change(). 
        // O ->unique() aqui garante que NINGUÉM use o mesmo e-mail duas vezes.
        $table->string('email', 100)->unique(); 
        
        $table->string('phone')->nullable();
        $table->date('birth_date');
        $table->enum('gender', ['M', 'F']);
        
        // DICA: Use decimal para altura e peso para evitar erros de arredondamento
        $table->decimal('height', 4, 2); 
        $table->decimal('weight', 5, 2)->nullable();

        // 2. Anamnese - Hábitos
        $table->text('sitting_time')->nullable();
        $table->text('physical_activity')->nullable();
        $table->boolean('is_smoker')->default(false);
        $table->text('diet_type')->nullable();
        $table->text('fluid_intake')->nullable();

        // 3. Histórico Médico
        $table->text('surgeries')->nullable();
        $table->text('aesthetic_treatments')->nullable();
        $table->text('allergies')->nullable();
        $table->text('bowel_function')->nullable();
        $table->text('orthopedic_issues')->nullable();
        $table->text('current_medical_treatment')->nullable();
        $table->text('skin_acids')->nullable();
        $table->text('orthomolecular_treatment')->nullable();
        $table->text('body_care_products')->nullable(); 

        // 4. Condições Específicas
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
        // Motivo: Esta linha causava o erro "Key column email doesn't exist" 
        // e permitiria e-mails iguais se os nomes fossem diferentes. 
        // A regra de e-mail único já foi definida na linha 14.
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

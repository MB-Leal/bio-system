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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            // Relacionamento com o Grupo (Professor)
            $table->foreignId('group_id')->nullable()->constrained()->onDelete('set null');

            // 1. Dados Pessoais e Cadastrais (Fixos)
            $table->string('name', 100);
            $table->string('email', 100)->unique(); 
            $table->string('phone')->nullable();
            $table->string('cell_group')->default('Não'); // Identificação da Célula (CL)
            $table->date('birth_date');
            $table->enum('gender', ['M', 'F']);
            
            // 2. Referências Iniciais
            // Mantemos altura e peso inicial para servir de base fixa na evolução histórica
            $table->decimal('height', 5, 2); 
            $table->decimal('weight', 5, 2)->nullable(); 

            // 3. Anamnese - Hábitos e Saúde (Dados de perfil de saúde)
            $table->text('sitting_time')->nullable();
            $table->text('physical_activity')->nullable();
            $table->text('surgeries')->nullable();
            $table->text('orthopedic_issues')->nullable();

            // 4. Histórico de Lesões e Fraturas
            $table->boolean('has_fracture')->default(false);
            $table->text('fracture_location')->nullable();
            $table->string('fracture_date')->nullable();
            $table->text('implants_details')->nullable();

            // 5. Notas Gerais e Anexos
            $table->text('health_notes')->nullable(); 
            $table->string('exam_pdf_path')->nullable(); // Caminho para o PDF enviado no cadastro
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
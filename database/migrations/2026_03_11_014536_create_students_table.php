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
        $table->foreignId('group_id')->nullable()->constrained(); 
        
        // Limitamos para 100 cada para o índice composto caber no limite de bytes
        $table->string('name', 100); 
        $table->string('email', 100);
        
        $table->date('birth_date');
        $table->enum('gender', ['M', 'F']);
        $table->float('height');
        $table->text('health_notes')->nullable();
        $table->timestamps();

        // Agora o índice terá (100+100) * 4 = 800 bytes. Cabe com folga!
        $table->unique(['name', 'email']); 
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

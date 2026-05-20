<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quartos', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 10)->unique();
            $table->foreignId('categoria_id')
                  ->constrained('categorias_quarto')
                  ->onDelete('restrict');
            $table->decimal('preco_diaria', 8, 2);
            $table->enum('status', ['disponivel', 'ocupado', 'manutencao'])->default('disponivel');
            $table->text('descricao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quartos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospede_id')->constrained('hospedes')->onDelete('restrict');
            $table->foreignId('quarto_id')->constrained('quartos')->onDelete('restrict');
            $table->foreignId('funcionario_id')->constrained('funcionarios')->onDelete('restrict');
            $table->date('data_checkin');
            $table->date('data_checkout');
            $table->decimal('valor_total', 10, 2);
            $table->enum('status', ['pendente', 'confirmada', 'cancelada', 'finalizada'])->default('pendente');
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};

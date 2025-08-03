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
        Schema::create('ordens_servico', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            $table->foreignId('tecnico_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('equipamento');
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->nullable();
            $table->text('defeito_relatado');
            $table->text('defeito_encontrado')->nullable();
            $table->text('solucao_aplicada')->nullable();
            $table->text('pecas_utilizadas')->nullable();
            $table->decimal('valor_mao_obra', 10, 2)->default(0);
            $table->decimal('valor_pecas', 10, 2)->default(0);
            $table->decimal('valor_total', 10, 2)->default(0);
            $table->enum('status', ['pendente', 'em_andamento', 'concluida', 'cancelada'])->default('pendente');
            $table->datetime('data_entrada');
            $table->datetime('data_saida')->nullable();
            $table->integer('garantia_dias')->default(0);
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index(['numero', 'status']);
            $table->index(['cliente_id', 'status']);
            $table->index(['tecnico_id', 'status']);
            $table->index('data_entrada');
            $table->index('data_saida');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordens_servico');
    }
};

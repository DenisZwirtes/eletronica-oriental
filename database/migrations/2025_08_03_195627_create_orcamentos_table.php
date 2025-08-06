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
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            $table->foreignId('atendente_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('equipamento');
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->nullable();
            $table->text('defeito_relatado');
            $table->text('diagnostico_preliminar')->nullable();
            $table->text('solucao_proposta')->nullable();
            $table->text('pecas_necessarias')->nullable();
            $table->decimal('valor_mao_obra', 10, 2)->default(0);
            $table->decimal('valor_pecas', 10, 2)->default(0);
            $table->decimal('valor_total', 10, 2)->default(0);
            $table->integer('validade_dias')->default(7);
            $table->enum('status', ['pendente', 'aprovado', 'rejeitado', 'convertido'])->default('pendente');
            $table->datetime('data_criacao');
            $table->datetime('data_validade');
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index(['numero', 'status']);
            $table->index(['cliente_id', 'status']);
            $table->index(['atendente_id', 'status']);
            $table->index('data_criacao');
            $table->index('data_validade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};

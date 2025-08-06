<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasAuditLog;
use App\Traits\HasStatusManagement;
use App\Enums\OrcamentoStatus;

class Orcamento extends Model
{
    use HasFactory, HasAuditLog, HasStatusManagement;

    protected $fillable = [
        'numero',
        'cliente_id',
        'atendente_id',
        'equipamento',
        'marca',
        'modelo',
        'numero_serie',
        'defeito_relatado',
        'diagnostico_preliminar',
        'solucao_proposta',
        'pecas_necessarias',
        'valor_mao_obra',
        'valor_pecas',
        'valor_total',
        'validade_dias',
        'status',
        'data_criacao',
        'data_validade',
        'observacoes',
    ];

    protected $casts = [
        'valor_mao_obra' => 'decimal:2',
        'valor_pecas' => 'decimal:2',
        'valor_total' => 'decimal:2',
        'data_criacao' => 'datetime',
        'data_validade' => 'datetime',
        'validade_dias' => 'integer',
    ];

    /**
     * Relacionamento com cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relacionamento com atendente
     */
    public function atendente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'atendente_id');
    }



    /**
     * Escopo para orçamentos pendentes
     */
    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }

    /**
     * Escopo para orçamentos aprovados
     */
    public function scopeAprovado($query)
    {
        return $query->where('status', 'aprovado');
    }

    /**
     * Escopo para orçamentos rejeitados
     */
    public function scopeRejeitado($query)
    {
        return $query->where('status', 'rejeitado');
    }

    /**
     * Escopo para orçamentos vencidos
     */
    public function scopeVencido($query)
    {
        return $query->where('data_validade', '<', now());
    }

    /**
     * Escopo para orçamentos válidos
     */
    public function scopeValido($query)
    {
        return $query->where('data_validade', '>=', now());
    }

    /**
     * Escopo para orçamentos por período
     */
    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('data_criacao', [$dataInicio, $dataFim]);
    }

    /**
     * Gera número do orçamento
     */
    public static function gerarNumero(): string
    {
        $ano = date('Y');
        $mes = date('m');
        $ultimoOrcamento = self::whereYear('created_at', $ano)
            ->whereMonth('created_at', $mes)
            ->orderBy('id', 'desc')
            ->first();

        $sequencial = $ultimoOrcamento ? (intval(substr($ultimoOrcamento->numero, -4)) + 1) : 1;

        return sprintf('ORC%s%s%04d', $ano, $mes, $sequencial);
    }

    /**
     * Calcula o valor total
     */
    public function calcularValorTotal(): float
    {
        return $this->valor_mao_obra + $this->valor_pecas;
    }

    /**
     * Verifica se está válido
     */
    public function estaValido(): bool
    {
        return $this->data_validade && now()->lte($this->data_validade);
    }

    /**
     * Obtém dias restantes de validade
     */
    public function getDiasValidadeRestantes(): int
    {
        if (!$this->estaValido()) {
            return 0;
        }

        return now()->diffInDays($this->data_validade, false);
    }

    /**
     * Aprova o orçamento
     */
    public function aprovar(): bool
    {
        $this->update(['status' => 'aprovado']);
        return true;
    }

    /**
     * Rejeita o orçamento
     */
    public function rejeitar(): bool
    {
        $this->update(['status' => 'rejeitado']);
        return true;
    }

    /**
     * Obtém o status formatado
     */
    public function getStatusFormatadoAttribute(): string
    {
        return match($this->status) {
            'pendente' => 'Pendente',
            'aprovado' => 'Aprovado',
            'rejeitado' => 'Rejeitado',
            'vencido' => 'Vencido',
            default => 'Desconhecido'
        };
    }

    /**
     * Obtém a cor do status
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pendente' => 'yellow',
            'aprovado' => 'green',
            'rejeitado' => 'red',
            'vencido' => 'gray',
            default => 'gray'
        };
    }
}

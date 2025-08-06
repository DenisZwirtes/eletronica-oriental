<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasAuditLog;
use App\Traits\HasStatusManagement;
use App\Enums\OrdemServicoStatus;

class OrdemServico extends Model
{
    use HasFactory, HasAuditLog, HasStatusManagement;

    protected $table = 'ordens_servico';

    protected $fillable = [
        'numero',
        'cliente_id',
        'tecnico_id',
        'equipamento',
        'marca',
        'modelo',
        'numero_serie',
        'defeito_relatado',
        'defeito_encontrado',
        'solucao_aplicada',
        'pecas_utilizadas',
        'valor_mao_obra',
        'valor_pecas',
        'valor_total',
        'status',
        'data_entrada',
        'data_saida',
        'garantia_dias',
        'observacoes',
    ];

    protected $casts = [
        'valor_mao_obra' => 'decimal:2',
        'valor_pecas' => 'decimal:2',
        'valor_total' => 'decimal:2',
        'data_entrada' => 'datetime',
        'data_saida' => 'datetime',
        'garantia_dias' => 'integer',
    ];

    /**
     * Relacionamento com cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relacionamento com técnico
     */
    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }



    /**
     * Escopo para ordens pendentes
     */
    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }

    /**
     * Escopo para ordens em andamento
     */
    public function scopeEmAndamento($query)
    {
        return $query->where('status', 'em_andamento');
    }

    /**
     * Escopo para ordens concluídas
     */
    public function scopeConcluida($query)
    {
        return $query->where('status', 'concluida');
    }

    /**
     * Escopo para ordens canceladas
     */
    public function scopeCancelada($query)
    {
        return $query->where('status', 'cancelada');
    }

    /**
     * Escopo para ordens por período
     */
    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('data_entrada', [$dataInicio, $dataFim]);
    }

    /**
     * Gera número da ordem de serviço
     */
    public static function gerarNumero(): string
    {
        $ano = date('Y');
        $mes = date('m');
        $ultimaOrdem = self::whereYear('created_at', $ano)
            ->whereMonth('created_at', $mes)
            ->orderBy('id', 'desc')
            ->first();

        $sequencial = $ultimaOrdem ? (intval(substr($ultimaOrdem->numero, -4)) + 1) : 1;

        return sprintf('%s%s%04d', $ano, $mes, $sequencial);
    }

    /**
     * Calcula o valor total
     */
    public function calcularValorTotal(): float
    {
        return $this->valor_mao_obra + $this->valor_pecas;
    }

    /**
     * Verifica se está em garantia
     */
    public function estaEmGarantia(): bool
    {
        if (!$this->data_saida || !$this->garantia_dias) {
            return false;
        }

        $dataLimite = $this->data_saida->addDays($this->garantia_dias);
        return now()->lte($dataLimite);
    }

    /**
     * Obtém dias restantes de garantia
     */
    public function getDiasGarantiaRestantes(): int
    {
        if (!$this->estaEmGarantia()) {
            return 0;
        }

        $dataLimite = $this->data_saida->addDays($this->garantia_dias);
        return now()->diffInDays($dataLimite, false);
    }

    /**
     * Obtém o status formatado
     */
    public function getStatusFormatadoAttribute(): string
    {
        return match($this->status) {
            'pendente' => 'Pendente',
            'em_andamento' => 'Em Andamento',
            'concluida' => 'Concluída',
            'cancelada' => 'Cancelada',
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
            'em_andamento' => 'blue',
            'concluida' => 'green',
            'cancelada' => 'red',
            default => 'gray'
        };
    }
}

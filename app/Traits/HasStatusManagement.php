<?php

namespace App\Traits;

use App\Enums\OrcamentoStatus;
use App\Enums\OrdemServicoStatus;

trait HasStatusManagement
{
    /**
     * Verifica se o status é ativo
     */
    public function isStatusActive(): bool
    {
        if (property_exists($this, 'status')) {
            return match($this->status) {
                'pendente', 'em_andamento' => true,
                default => false,
            };
        }
        return false;
    }

    /**
     * Verifica se o status permite edição
     */
    public function canEdit(): bool
    {
        if (property_exists($this, 'status')) {
            return match($this->status) {
                'pendente', 'em_andamento' => true,
                default => false,
            };
        }
        return false;
    }

    /**
     * Verifica se o status permite cancelamento
     */
    public function canCancel(): bool
    {
        if (property_exists($this, 'status')) {
            return match($this->status) {
                'pendente', 'em_andamento' => true,
                default => false,
            };
        }
        return false;
    }

    /**
     * Verifica se o status permite conclusão
     */
    public function canComplete(): bool
    {
        if (property_exists($this, 'status')) {
            return match($this->status) {
                'em_andamento' => true,
                default => false,
            };
        }
        return false;
    }

    /**
     * Obtém a cor do status
     */
    public function getStatusColor(): string
    {
        if (property_exists($this, 'status')) {
            return match($this->status) {
                'pendente' => 'yellow',
                'em_andamento' => 'blue',
                'concluida', 'aprovado' => 'green',
                'cancelada', 'rejeitado' => 'red',
                'convertido' => 'purple',
                default => 'gray',
            };
        }
        return 'gray';
    }

    /**
     * Obtém o label do status
     */
    public function getStatusLabel(): string
    {
        if (property_exists($this, 'status')) {
            return match($this->status) {
                'pendente' => 'Pendente',
                'em_andamento' => 'Em Andamento',
                'concluida' => 'Concluída',
                'cancelada' => 'Cancelada',
                'aprovado' => 'Aprovado',
                'rejeitado' => 'Rejeitado',
                'convertido' => 'Convertido em OS',
                default => 'Desconhecido',
            };
        }
        return 'Desconhecido';
    }

    /**
     * Verifica se é um orçamento
     */
    public function isOrcamento(): bool
    {
        return property_exists($this, 'table') && $this->table === 'orcamentos';
    }

    /**
     * Verifica se é uma ordem de serviço
     */
    public function isOrdemServico(): bool
    {
        return property_exists($this, 'table') && $this->table === 'ordens_servico';
    }

    /**
     * Obtém o enum de status apropriado
     */
    public function getStatusEnum(): OrcamentoStatus|OrdemServicoStatus|null
    {
        if (!$this->status) {
            return null;
        }

        if ($this->isOrcamento()) {
            return OrcamentoStatus::fromString($this->status);
        }

        if ($this->isOrdemServico()) {
            return OrdemServicoStatus::fromString($this->status);
        }

        return null;
    }

    /**
     * Atualiza o status
     */
    public function updateStatus(string $newStatus): bool
    {
        if (!property_exists($this, 'status')) {
            return false;
        }

        $this->status = $newStatus;
        return $this->save();
    }

    /**
     * Marca como pendente
     */
    public function markAsPending(): bool
    {
        return $this->updateStatus('pendente');
    }

    /**
     * Marca como em andamento
     */
    public function markAsInProgress(): bool
    {
        return $this->updateStatus('em_andamento');
    }

    /**
     * Marca como concluído
     */
    public function markAsCompleted(): bool
    {
        return $this->updateStatus('concluida');
    }

    /**
     * Marca como cancelado
     */
    public function markAsCancelled(): bool
    {
        return $this->updateStatus('cancelada');
    }

    /**
     * Marca como aprovado (apenas para orçamentos)
     */
    public function markAsApproved(): bool
    {
        if ($this->isOrcamento()) {
            return $this->updateStatus('aprovado');
        }
        return false;
    }

    /**
     * Marca como rejeitado (apenas para orçamentos)
     */
    public function markAsRejected(): bool
    {
        if ($this->isOrcamento()) {
            return $this->updateStatus('rejeitado');
        }
        return false;
    }

    /**
     * Marca como convertido (apenas para orçamentos)
     */
    public function markAsConverted(): bool
    {
        if ($this->isOrcamento()) {
            return $this->updateStatus('convertido');
        }
        return false;
    }
}

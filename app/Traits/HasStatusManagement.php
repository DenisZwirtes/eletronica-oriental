<?php

namespace App\Traits;

use App\Enums\OrcamentoStatus;
use App\Enums\OrdemServicoStatus;

trait HasStatusManagement
{
    public function isStatusActive(): bool
    {
        $status = $this->getStatusEnum();

        if ($status instanceof OrcamentoStatus) {
            return $status->isActive();
        }

        if ($status instanceof OrdemServicoStatus) {
            return $status->isActive();
        }

        return false;
    }

    public function getStatusColor(): string
    {
        $status = $this->getStatusEnum();

        if ($status instanceof OrcamentoStatus) {
            return $status->color();
        }

        if ($status instanceof OrdemServicoStatus) {
            return $status->color();
        }

        return 'gray';
    }

    public function getStatusEnum(): OrcamentoStatus|OrdemServicoStatus|null
    {
        if (!$this->status) {
            return null;
        }

        try {
            return OrcamentoStatus::fromString($this->status);
        } catch (\InvalidArgumentException $e) {
            try {
                return OrdemServicoStatus::fromString($this->status);
            } catch (\InvalidArgumentException $e) {
                return null;
            }
        }
    }

    public function updateStatus(string $newStatus): bool
    {
        try {
            $newStatusEnum = OrcamentoStatus::fromString($newStatus);
            $this->update(['status' => $newStatusEnum->value]);
            return true;
        } catch (\InvalidArgumentException $e) {
            try {
                $newStatusEnum = OrdemServicoStatus::fromString($newStatus);
                $this->update(['status' => $newStatusEnum->value]);
                return true;
            } catch (\InvalidArgumentException $e) {
                return false;
            }
        }
    }

    // Métodos específicos para Orçamento
    public function markAsPending(): void
    {
        $this->update(['status' => OrcamentoStatus::PENDENTE->value]);
    }

    public function markAsApproved(): void
    {
        $this->update(['status' => OrcamentoStatus::APROVADO->value]);
    }

    public function markAsRejected(): void
    {
        $this->update(['status' => OrcamentoStatus::REJEITADO->value]);
    }

    public function markAsConverted(): void
    {
        $this->update(['status' => OrcamentoStatus::CONVERTIDO->value]);
    }

    // Métodos específicos para Ordem de Serviço
    public function markAsInProgress(): void
    {
        $this->update(['status' => OrdemServicoStatus::EM_ANDAMENTO->value]);
    }

    public function markAsCompleted(): void
    {
        $this->update(['status' => OrdemServicoStatus::CONCLUIDA->value]);
    }

    public function markAsCancelled(): void
    {
        $this->update(['status' => OrdemServicoStatus::CANCELADA->value]);
    }

    // Métodos de verificação
    public function canEdit(): bool
    {
        $status = $this->getStatusEnum();

        if ($status instanceof OrcamentoStatus) {
            return in_array($status, [OrcamentoStatus::PENDENTE, OrcamentoStatus::APROVADO]);
        }

        if ($status instanceof OrdemServicoStatus) {
            return in_array($status, [OrdemServicoStatus::PENDENTE, OrdemServicoStatus::EM_ANDAMENTO]);
        }

        return false;
    }

    public function canCancel(): bool
    {
        $status = $this->getStatusEnum();

        if ($status instanceof OrcamentoStatus) {
            return in_array($status, [OrcamentoStatus::PENDENTE, OrcamentoStatus::APROVADO]);
        }

        if ($status instanceof OrdemServicoStatus) {
            return in_array($status, [OrdemServicoStatus::PENDENTE, OrdemServicoStatus::EM_ANDAMENTO]);
        }

        return false;
    }

    public function getStatusDisplayLabel(): string
    {
        $status = $this->getStatusEnum();

        if ($status instanceof OrcamentoStatus) {
            return $status->label();
        }

        if ($status instanceof OrdemServicoStatus) {
            return $status->label();
        }

        return 'Desconhecido';
    }
}

<?php

namespace App\Enums;

enum OrdemServicoStatus: string
{
    case PENDENTE = 'pendente';
    case EM_ANDAMENTO = 'em_andamento';
    case CONCLUIDA = 'concluida';
    case CANCELADA = 'cancelada';

    public function label(): string
    {
        return match($this) {
            self::PENDENTE => 'Pendente',
            self::EM_ANDAMENTO => 'Em Andamento',
            self::CONCLUIDA => 'Concluída',
            self::CANCELADA => 'Cancelada',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDENTE => 'yellow',
            self::EM_ANDAMENTO => 'blue',
            self::CONCLUIDA => 'green',
            self::CANCELADA => 'red',
        };
    }

    public function isActive(): bool
    {
        return in_array($this, [self::PENDENTE, self::EM_ANDAMENTO]);
    }

    public function canStart(): bool
    {
        return $this === self::PENDENTE;
    }

    public function canComplete(): bool
    {
        return $this === self::EM_ANDAMENTO;
    }

    public function canCancel(): bool
    {
        return in_array($this, [self::PENDENTE, self::EM_ANDAMENTO]);
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($status) => [
            $status->value => $status->label()
        ])->toArray();
    }

    public static function fromString(string $value): self
    {
        return match($value) {
            'pendente' => self::PENDENTE,
            'em_andamento' => self::EM_ANDAMENTO,
            'concluida' => self::CONCLUIDA,
            'cancelada' => self::CANCELADA,
            default => throw new \InvalidArgumentException("Status inválido: {$value}")
        };
    }
}

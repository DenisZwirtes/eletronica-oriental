<?php

namespace App\Enums;

enum OrcamentoStatus: string
{
    case PENDENTE = 'pendente';
    case APROVADO = 'aprovado';
    case REJEITADO = 'rejeitado';
    case CONVERTIDO = 'convertido';

    public function label(): string
    {
        return match($this) {
            self::PENDENTE => 'Pendente',
            self::APROVADO => 'Aprovado',
            self::REJEITADO => 'Rejeitado',
            self::CONVERTIDO => 'Convertido em OS',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDENTE => 'yellow',
            self::APROVADO => 'green',
            self::REJEITADO => 'red',
            self::CONVERTIDO => 'blue',
        };
    }

    public function isActive(): bool
    {
        return in_array($this, [self::PENDENTE, self::APROVADO]);
    }

    public function canConvert(): bool
    {
        return $this === self::APROVADO;
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
            'aprovado' => self::APROVADO,
            'rejeitado' => self::REJEITADO,
            'convertido' => self::CONVERTIDO,
            default => throw new \InvalidArgumentException("Status inválido: {$value}")
        };
    }
}

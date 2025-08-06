<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case PROPRIETARIO = 'proprietario';
    case TECNICO = 'tecnico';
    case ATENDENTE = 'atendente';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrador',
            self::PROPRIETARIO => 'Proprietário',
            self::TECNICO => 'Técnico',
            self::ATENDENTE => 'Atendente',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::ADMIN => 'Acesso completo ao sistema',
            self::PROPRIETARIO => 'Gestão de clientes, orçamentos e ordens de serviço',
            self::TECNICO => 'Execução de serviços e reparos',
            self::ATENDENTE => 'Atendimento ao cliente e gestão básica',
        };
    }

    public function permissions(): array
    {
        return match($this) {
            self::ADMIN => [
                'view-dashboard',
                'manage-users',
                'manage-clients',
                'manage-quotes',
                'manage-service-orders',
                'view-reports',
                'manage-settings',
            ],
            self::PROPRIETARIO => [
                'view-dashboard',
                'manage-clients',
                'manage-quotes',
                'manage-service-orders',
                'view-reports',
            ],
            self::TECNICO => [
                'view-dashboard',
                'view-service-orders',
                'update-service-orders',
                'complete-service-orders',
            ],
            self::ATENDENTE => [
                'view-dashboard',
                'create-clients',
                'view-clients',
                'create-quotes',
                'view-quotes',
                'create-service-orders',
                'view-service-orders',
            ],
        };
    }

    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    public function isProprietario(): bool
    {
        return $this === self::PROPRIETARIO;
    }

    public function isTecnico(): bool
    {
        return $this === self::TECNICO;
    }

    public function isAtendente(): bool
    {
        return $this === self::ATENDENTE;
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($role) => [
            $role->value => $role->label()
        ])->toArray();
    }

    public static function fromString(string $value): self
    {
        return match($value) {
            'admin' => self::ADMIN,
            'proprietario' => self::PROPRIETARIO,
            'tecnico' => self::TECNICO,
            'atendente' => self::ATENDENTE,
            default => throw new \InvalidArgumentException("Role inválida: {$value}")
        };
    }
}

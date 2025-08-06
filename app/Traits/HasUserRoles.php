<?php

namespace App\Traits;

use App\Enums\UserRole;
use Spatie\Permission\Models\Role;

trait HasUserRoles
{
    /**
     * Verifica se o usuário tem uma role específica
     */
    public function hasRole(UserRole $role): bool
    {
        return $this->roles()->where('name', $role->value)->exists();
    }

    /**
     * Verifica se o usuário tem qualquer uma das roles especificadas
     */
    public function hasAnyRole(array $roles): bool
    {
        $roleNames = array_map(fn(UserRole $role) => $role->value, $roles);
        return $this->roles()->whereIn('name', $roleNames)->exists();
    }

    /**
     * Verifica se o usuário tem todas as roles especificadas
     */
    public function hasAllRoles(array $roles): bool
    {
        $roleNames = array_map(fn(UserRole $role) => $role->value, $roles);
        return $this->roles()->whereIn('name', $roleNames)->count() === count($roles);
    }

    /**
     * Atribui uma role ao usuário
     */
    public function assignUserRole(UserRole $role): void
    {
        $roleModel = Role::firstOrCreate(['name' => $role->value]);
        $this->assignRole($roleModel->name);
    }

    /**
     * Remove uma role do usuário
     */
    public function removeUserRole(UserRole $role): void
    {
        $this->removeRole($role->value);
    }

    /**
     * Sincroniza as roles do usuário (remove todas e adiciona as especificadas)
     */
    public function syncUserRoles(array $roles): void
    {
        $roleNames = array_map(fn(UserRole $role) => $role->value, $roles);
        $this->syncRoles($roleNames);
    }

    /**
     * Obtém a primeira role do usuário
     */
    public function getFirstRole(): ?UserRole
    {
        $role = $this->roles()->first();
        return $role ? UserRole::fromString($role->name) : null;
    }

    /**
     * Obtém todas as roles do usuário como enums
     */
    public function getUserRoles(): array
    {
        return $this->roles()->get()->map(function ($role) {
            return UserRole::fromString($role->name);
        })->toArray();
    }

    /**
     * Verifica se o usuário é admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(UserRole::ADMIN);
    }

    /**
     * Verifica se o usuário é proprietário
     */
    public function isProprietario(): bool
    {
        return $this->hasRole(UserRole::PROPRIETARIO);
    }

    /**
     * Verifica se o usuário é técnico
     */
    public function isTecnico(): bool
    {
        return $this->hasRole(UserRole::TECNICO);
    }

    /**
     * Verifica se o usuário é atendente
     */
    public function isAtendente(): bool
    {
        return $this->hasRole(UserRole::ATENDENTE);
    }

    /**
     * Verifica se o usuário pode gerenciar clientes
     */
    public function canManageClients(): bool
    {
        return $this->hasAnyRole([UserRole::ADMIN, UserRole::PROPRIETARIO]);
    }

    /**
     * Verifica se o usuário pode gerenciar orçamentos
     */
    public function canManageQuotes(): bool
    {
        return $this->hasAnyRole([UserRole::ADMIN, UserRole::PROPRIETARIO]);
    }

    /**
     * Verifica se o usuário pode gerenciar ordens de serviço
     */
    public function canManageServiceOrders(): bool
    {
        return $this->hasAnyRole([UserRole::ADMIN, UserRole::PROPRIETARIO]);
    }

    /**
     * Verifica se o usuário pode executar serviços
     */
    public function canExecuteServices(): bool
    {
        return $this->hasAnyRole([UserRole::ADMIN, UserRole::TECNICO]);
    }

    /**
     * Verifica se o usuário pode atender clientes
     */
    public function canAttendClients(): bool
    {
        return $this->hasAnyRole([UserRole::ADMIN, UserRole::ATENDENTE]);
    }

    /**
     * Obtém o nome da role principal do usuário
     */
    public function getRoleName(): string
    {
        $role = $this->getFirstRole();
        return $role ? $role->label() : 'Sem Role';
    }

    /**
     * Obtém a descrição da role principal do usuário
     */
    public function getRoleDescription(): string
    {
        $role = $this->getFirstRole();
        return $role ? $role->description() : 'Usuário sem permissões definidas';
    }
}

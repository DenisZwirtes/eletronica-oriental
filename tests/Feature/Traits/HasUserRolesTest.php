<?php

use App\Models\User;
use App\Enums\UserRole;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();

    // Criar roles se não existirem
    foreach (UserRole::cases() as $role) {
        Role::firstOrCreate(['name' => $role->value]);
    }
});

test('deve verificar se usuário tem role específica', function () {
    $this->user->assignRole(UserRole::PROPRIETARIO->value);

    expect($this->user->hasRole(UserRole::PROPRIETARIO->value))->toBeTrue()
        ->and($this->user->hasRole(UserRole::TECNICO->value))->toBeFalse();
});

test('deve atribuir role ao usuário', function () {
    $this->user->assignRole(UserRole::PROPRIETARIO->value);

    expect($this->user->hasRole(UserRole::PROPRIETARIO->value))->toBeTrue();
});

test('deve remover role do usuário', function () {
    $this->user->assignRole(UserRole::PROPRIETARIO->value);
    $this->user->removeRole(UserRole::PROPRIETARIO->value);

    expect($this->user->hasRole(UserRole::PROPRIETARIO->value))->toBeFalse();
});

test('deve sincronizar roles do usuário', function () {
    $this->user->syncRoles([UserRole::PROPRIETARIO->value, UserRole::TECNICO->value]);

    expect($this->user->hasRole(UserRole::PROPRIETARIO->value))->toBeTrue()
        ->and($this->user->hasRole(UserRole::TECNICO->value))->toBeTrue()
        ->and($this->user->hasRole(UserRole::ADMIN->value))->toBeFalse();
});

test('deve verificar se usuário tem qualquer role', function () {
    $this->user->assignRole(UserRole::PROPRIETARIO->value);

    expect($this->user->hasAnyRole([UserRole::PROPRIETARIO->value, UserRole::TECNICO->value]))->toBeTrue()
        ->and($this->user->hasAnyRole([UserRole::ADMIN->value, UserRole::ATENDENTE->value]))->toBeFalse();
});

test('deve verificar se usuário tem todas as roles', function () {
    $this->user->syncRoles([UserRole::PROPRIETARIO->value, UserRole::TECNICO->value]);

    expect($this->user->hasAllRoles([UserRole::PROPRIETARIO->value, UserRole::TECNICO->value]))->toBeTrue()
        ->and($this->user->hasAllRoles([UserRole::PROPRIETARIO->value, UserRole::ADMIN->value]))->toBeFalse();
});

test('deve retornar roles do usuário', function () {
    $this->user->syncRoles([UserRole::PROPRIETARIO->value, UserRole::TECNICO->value]);

    $roles = $this->user->roles;

    expect($roles)->toHaveCount(2)
        ->and($roles->pluck('name')->toArray())->toContain(UserRole::PROPRIETARIO->value)
        ->and($roles->pluck('name')->toArray())->toContain(UserRole::TECNICO->value);
});

test('deve retornar nomes das roles do usuário', function () {
    $this->user->syncRoles([UserRole::PROPRIETARIO->value, UserRole::TECNICO->value]);

    $roleNames = $this->user->roles->pluck('name')->toArray();

    expect($roleNames)->toHaveCount(2)
        ->and($roleNames)->toContain(UserRole::PROPRIETARIO->value)
        ->and($roleNames)->toContain(UserRole::TECNICO->value);
});

test('deve verificar se usuário é admin', function () {
    $this->user->assignRole(UserRole::ADMIN->value);

    expect($this->user->hasRole(UserRole::ADMIN->value))->toBeTrue();

    $this->user->removeRole(UserRole::ADMIN->value);
    $this->user->assignRole(UserRole::PROPRIETARIO->value);

    expect($this->user->hasRole(UserRole::ADMIN->value))->toBeFalse();
});

test('deve verificar se usuário é proprietário', function () {
    $this->user->assignRole(UserRole::PROPRIETARIO->value);

    expect($this->user->hasRole(UserRole::PROPRIETARIO->value))->toBeTrue();

    $this->user->removeRole(UserRole::PROPRIETARIO->value);
    $this->user->assignRole(UserRole::TECNICO->value);

    expect($this->user->hasRole(UserRole::PROPRIETARIO->value))->toBeFalse();
});

test('deve verificar se usuário é técnico', function () {
    $this->user->assignRole(UserRole::TECNICO->value);

    expect($this->user->hasRole(UserRole::TECNICO->value))->toBeTrue();

    $this->user->removeRole(UserRole::TECNICO->value);
    $this->user->assignRole(UserRole::ATENDENTE->value);

    expect($this->user->hasRole(UserRole::TECNICO->value))->toBeFalse();
});

test('deve verificar se usuário é atendente', function () {
    $this->user->assignRole(UserRole::ATENDENTE->value);

    expect($this->user->hasRole(UserRole::ATENDENTE->value))->toBeTrue();

    $this->user->removeRole(UserRole::ATENDENTE->value);
    $this->user->assignRole(UserRole::PROPRIETARIO->value);

    expect($this->user->hasRole(UserRole::ATENDENTE->value))->toBeFalse();
});

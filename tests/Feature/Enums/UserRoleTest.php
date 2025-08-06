<?php

use App\Enums\UserRole;

test('deve retornar label correto para cada role', function () {
    expect(UserRole::ADMIN->label())->toBe('Administrador')
        ->and(UserRole::PROPRIETARIO->label())->toBe('Proprietário')
        ->and(UserRole::TECNICO->label())->toBe('Técnico')
        ->and(UserRole::ATENDENTE->label())->toBe('Atendente');
});

test('deve retornar descrição correta para cada role', function () {
    expect(UserRole::ADMIN->description())->toBe('Acesso completo ao sistema')
        ->and(UserRole::PROPRIETARIO->description())->toBe('Gestão de clientes, orçamentos e ordens de serviço')
        ->and(UserRole::TECNICO->description())->toBe('Execução de serviços e reparos')
        ->and(UserRole::ATENDENTE->description())->toBe('Atendimento ao cliente e gestão básica');
});

test('deve verificar se role é admin', function () {
    expect(UserRole::ADMIN->isAdmin())->toBeTrue()
        ->and(UserRole::PROPRIETARIO->isAdmin())->toBeFalse()
        ->and(UserRole::TECNICO->isAdmin())->toBeFalse()
        ->and(UserRole::ATENDENTE->isAdmin())->toBeFalse();
});

test('deve verificar se role é proprietário', function () {
    expect(UserRole::ADMIN->isProprietario())->toBeFalse()
        ->and(UserRole::PROPRIETARIO->isProprietario())->toBeTrue()
        ->and(UserRole::TECNICO->isProprietario())->toBeFalse()
        ->and(UserRole::ATENDENTE->isProprietario())->toBeFalse();
});

test('deve verificar se role é técnico', function () {
    expect(UserRole::ADMIN->isTecnico())->toBeFalse()
        ->and(UserRole::PROPRIETARIO->isTecnico())->toBeFalse()
        ->and(UserRole::TECNICO->isTecnico())->toBeTrue()
        ->and(UserRole::ATENDENTE->isTecnico())->toBeFalse();
});

test('deve verificar se role é atendente', function () {
    expect(UserRole::ADMIN->isAtendente())->toBeFalse()
        ->and(UserRole::PROPRIETARIO->isAtendente())->toBeFalse()
        ->and(UserRole::TECNICO->isAtendente())->toBeFalse()
        ->and(UserRole::ATENDENTE->isAtendente())->toBeTrue();
});

test('deve retornar permissões para cada role', function () {
    expect(UserRole::ADMIN->permissions())->toContain('manage-users')
        ->and(UserRole::PROPRIETARIO->permissions())->toContain('manage-clients')
        ->and(UserRole::TECNICO->permissions())->toContain('update-service-orders')
        ->and(UserRole::ATENDENTE->permissions())->toContain('create-clients');
});

test('deve retornar opções para select', function () {
    $options = UserRole::options();

    expect($options)->toBe([
        'admin' => 'Administrador',
        'proprietario' => 'Proprietário',
        'tecnico' => 'Técnico',
        'atendente' => 'Atendente',
    ]);
});

test('deve criar enum a partir de string', function () {
    expect(UserRole::fromString('admin'))->toBe(UserRole::ADMIN)
        ->and(UserRole::fromString('proprietario'))->toBe(UserRole::PROPRIETARIO)
        ->and(UserRole::fromString('tecnico'))->toBe(UserRole::TECNICO)
        ->and(UserRole::fromString('atendente'))->toBe(UserRole::ATENDENTE);
});

test('deve lançar exceção para string inválida', function () {
    expect(fn() => UserRole::fromString('invalido'))
        ->toThrow(\InvalidArgumentException::class);
});

test('deve retornar todos os casos do enum', function () {
    $cases = UserRole::cases();

    expect($cases)->toHaveCount(4)
        ->and($cases)->toContain(UserRole::ADMIN)
        ->and($cases)->toContain(UserRole::PROPRIETARIO)
        ->and($cases)->toContain(UserRole::TECNICO)
        ->and($cases)->toContain(UserRole::ATENDENTE);
});

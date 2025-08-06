<?php

use App\Enums\OrdemServicoStatus;

test('deve retornar label correto para cada status', function () {
    expect(OrdemServicoStatus::PENDENTE->label())->toBe('Pendente')
        ->and(OrdemServicoStatus::EM_ANDAMENTO->label())->toBe('Em Andamento')
        ->and(OrdemServicoStatus::CONCLUIDA->label())->toBe('Concluída')
        ->and(OrdemServicoStatus::CANCELADA->label())->toBe('Cancelada');
});

test('deve retornar cor correta para cada status', function () {
    expect(OrdemServicoStatus::PENDENTE->color())->toBe('yellow')
        ->and(OrdemServicoStatus::EM_ANDAMENTO->color())->toBe('blue')
        ->and(OrdemServicoStatus::CONCLUIDA->color())->toBe('green')
        ->and(OrdemServicoStatus::CANCELADA->color())->toBe('red');
});

test('deve verificar se status está ativo', function () {
    expect(OrdemServicoStatus::PENDENTE->isActive())->toBeTrue()
        ->and(OrdemServicoStatus::EM_ANDAMENTO->isActive())->toBeTrue()
        ->and(OrdemServicoStatus::CONCLUIDA->isActive())->toBeFalse()
        ->and(OrdemServicoStatus::CANCELADA->isActive())->toBeFalse();
});

test('deve verificar se status pode ser iniciado', function () {
    expect(OrdemServicoStatus::PENDENTE->canStart())->toBeTrue()
        ->and(OrdemServicoStatus::EM_ANDAMENTO->canStart())->toBeFalse()
        ->and(OrdemServicoStatus::CONCLUIDA->canStart())->toBeFalse()
        ->and(OrdemServicoStatus::CANCELADA->canStart())->toBeFalse();
});

test('deve verificar se status pode ser concluído', function () {
    expect(OrdemServicoStatus::PENDENTE->canComplete())->toBeFalse()
        ->and(OrdemServicoStatus::EM_ANDAMENTO->canComplete())->toBeTrue()
        ->and(OrdemServicoStatus::CONCLUIDA->canComplete())->toBeFalse()
        ->and(OrdemServicoStatus::CANCELADA->canComplete())->toBeFalse();
});

test('deve verificar se status pode ser cancelado', function () {
    expect(OrdemServicoStatus::PENDENTE->canCancel())->toBeTrue()
        ->and(OrdemServicoStatus::EM_ANDAMENTO->canCancel())->toBeTrue()
        ->and(OrdemServicoStatus::CONCLUIDA->canCancel())->toBeFalse()
        ->and(OrdemServicoStatus::CANCELADA->canCancel())->toBeFalse();
});

test('deve retornar opções para select', function () {
    $options = OrdemServicoStatus::options();

    expect($options)->toBe([
        'pendente' => 'Pendente',
        'em_andamento' => 'Em Andamento',
        'concluida' => 'Concluída',
        'cancelada' => 'Cancelada',
    ]);
});

test('deve criar enum a partir de string', function () {
    expect(OrdemServicoStatus::fromString('pendente'))->toBe(OrdemServicoStatus::PENDENTE)
        ->and(OrdemServicoStatus::fromString('em_andamento'))->toBe(OrdemServicoStatus::EM_ANDAMENTO)
        ->and(OrdemServicoStatus::fromString('concluida'))->toBe(OrdemServicoStatus::CONCLUIDA)
        ->and(OrdemServicoStatus::fromString('cancelada'))->toBe(OrdemServicoStatus::CANCELADA);
});

test('deve lançar exceção para string inválida', function () {
    expect(fn() => OrdemServicoStatus::fromString('invalido'))
        ->toThrow(\InvalidArgumentException::class);
});

test('deve retornar todos os casos do enum', function () {
    $cases = OrdemServicoStatus::cases();

    expect($cases)->toHaveCount(4)
        ->and($cases)->toContain(OrdemServicoStatus::PENDENTE)
        ->and($cases)->toContain(OrdemServicoStatus::EM_ANDAMENTO)
        ->and($cases)->toContain(OrdemServicoStatus::CONCLUIDA)
        ->and($cases)->toContain(OrdemServicoStatus::CANCELADA);
});

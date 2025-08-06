<?php

use App\Enums\OrcamentoStatus;

test('deve retornar label correto para cada status', function () {
    expect(OrcamentoStatus::PENDENTE->label())->toBe('Pendente')
        ->and(OrcamentoStatus::APROVADO->label())->toBe('Aprovado')
        ->and(OrcamentoStatus::REJEITADO->label())->toBe('Rejeitado')
        ->and(OrcamentoStatus::CONVERTIDO->label())->toBe('Convertido em OS');
});

test('deve retornar cor correta para cada status', function () {
    expect(OrcamentoStatus::PENDENTE->color())->toBe('yellow')
        ->and(OrcamentoStatus::APROVADO->color())->toBe('green')
        ->and(OrcamentoStatus::REJEITADO->color())->toBe('red')
        ->and(OrcamentoStatus::CONVERTIDO->color())->toBe('blue');
});

test('deve verificar se status está ativo', function () {
    expect(OrcamentoStatus::PENDENTE->isActive())->toBeTrue()
        ->and(OrcamentoStatus::APROVADO->isActive())->toBeTrue()
        ->and(OrcamentoStatus::REJEITADO->isActive())->toBeFalse()
        ->and(OrcamentoStatus::CONVERTIDO->isActive())->toBeFalse();
});

test('deve verificar se status pode ser convertido', function () {
    expect(OrcamentoStatus::PENDENTE->canConvert())->toBeFalse()
        ->and(OrcamentoStatus::APROVADO->canConvert())->toBeTrue()
        ->and(OrcamentoStatus::REJEITADO->canConvert())->toBeFalse()
        ->and(OrcamentoStatus::CONVERTIDO->canConvert())->toBeFalse();
});

test('deve retornar opções para select', function () {
    $options = OrcamentoStatus::options();

    expect($options)->toBe([
        'pendente' => 'Pendente',
        'aprovado' => 'Aprovado',
        'rejeitado' => 'Rejeitado',
        'convertido' => 'Convertido em OS',
    ]);
});

test('deve criar enum a partir de string', function () {
    expect(OrcamentoStatus::fromString('pendente'))->toBe(OrcamentoStatus::PENDENTE)
        ->and(OrcamentoStatus::fromString('aprovado'))->toBe(OrcamentoStatus::APROVADO)
        ->and(OrcamentoStatus::fromString('rejeitado'))->toBe(OrcamentoStatus::REJEITADO)
        ->and(OrcamentoStatus::fromString('convertido'))->toBe(OrcamentoStatus::CONVERTIDO);
});

test('deve lançar exceção para string inválida', function () {
    expect(fn() => OrcamentoStatus::fromString('invalido'))
        ->toThrow(\InvalidArgumentException::class);
});

test('deve retornar todos os casos do enum', function () {
    $cases = OrcamentoStatus::cases();

    expect($cases)->toHaveCount(4)
        ->and($cases)->toContain(OrcamentoStatus::PENDENTE)
        ->and($cases)->toContain(OrcamentoStatus::APROVADO)
        ->and($cases)->toContain(OrcamentoStatus::REJEITADO)
        ->and($cases)->toContain(OrcamentoStatus::CONVERTIDO);
});

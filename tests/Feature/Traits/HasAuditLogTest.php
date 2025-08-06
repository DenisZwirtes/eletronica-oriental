<?php

use App\Models\Cliente;
use App\Models\Orcamento;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    // Limpar atividades anteriores
    Activity::truncate();
});

test('deve retornar opções de log corretas', function () {
    $cliente = Cliente::factory()->create();

    $logOptions = $cliente->getActivitylogOptions();

    expect($logOptions)->not->toBeNull();
});

test('deve retornar descrição da atividade', function () {
    $cliente = Cliente::factory()->create(['nome' => 'João Silva']);

    $description = $cliente->getActivityDescription('created');

    expect($description)->toBe('Cliente foi criado');
});

test('deve retornar propriedades da atividade', function () {
    $cliente = Cliente::factory()->create([
        'nome' => 'João Silva',
        'email' => 'joao@exemplo.com'
    ]);

    $properties = $cliente->getActivityProperties();

    expect($properties)->toBeArray();
});

test('deve verificar se deve registrar atividade', function () {
    $cliente = Cliente::factory()->create();

    expect($cliente->shouldLogActivity('created'))->toBeTrue()
        ->and($cliente->shouldLogActivity('updated'))->toBeTrue()
        ->and($cliente->shouldLogActivity('deleted'))->toBeTrue()
        ->and($cliente->shouldLogActivity('restored'))->toBeFalse();
});

test('deve retornar nome da tabela', function () {
    $cliente = Cliente::factory()->create();

    $tableName = $cliente->getTableName();

    expect($tableName)->toBe('clientes');
});

test('deve retornar label do status baseado no campo ativo', function () {
    $cliente = Cliente::factory()->create(['ativo' => true]);

    expect($cliente->ativo)->toBeTrue();

    $statusLabel = $cliente->getStatusLabel();

    expect($statusLabel)->toBe('Ativo');

    $cliente->update(['ativo' => false]);

    expect($cliente->fresh()->ativo)->toBeFalse();

    $statusLabel = $cliente->getStatusLabel();

    expect($statusLabel)->toBe('Inativo');
});

test('deve retornar N/A para modelos sem campo ativo', function () {
    $orcamento = Orcamento::factory()->create();

    $statusLabel = $orcamento->getStatusLabel();

    expect($statusLabel)->toBe('N/A');
});

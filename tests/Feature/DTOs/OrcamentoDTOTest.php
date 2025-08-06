<?php

use App\DTOs\OrcamentoDTO;
use App\Models\Orcamento;
use App\Models\Cliente;
use App\Enums\OrcamentoStatus;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->orcamentoData = [
        'cliente_id' => Cliente::factory()->create()->id,
        'numero' => 'ORC-001',
        'defeito_relatado' => 'Reparo de computador',
        'valor_total' => 150.00,
        'status' => OrcamentoStatus::PENDENTE->value,
        'data_criacao' => '2024-01-15',
        'data_validade' => '2024-02-15',
        'observacoes' => 'Orçamento para cliente VIP',
    ];
});

test('deve criar DTO a partir de request', function () {
    $request = Request::create('/', 'POST', $this->orcamentoData);

    $dto = OrcamentoDTO::fromRequest($request);

    expect($dto->cliente_id)->toBe($this->orcamentoData['cliente_id'])
        ->and($dto->numero)->toBe('ORC-001')
        ->and($dto->defeito_relatado)->toBe('Reparo de computador')
        ->and($dto->valor_total)->toBe(150.00)
        ->and($dto->status)->toBe(OrcamentoStatus::PENDENTE)
        ->and($dto->data_criacao)->toBe('2024-01-15')
        ->and($dto->data_validade)->toBe('2024-02-15')
        ->and($dto->observacoes)->toBe('Orçamento para cliente VIP');
});

test('deve criar DTO a partir de modelo', function () {
    $orcamento = Orcamento::factory()->create($this->orcamentoData);

    $dto = OrcamentoDTO::fromModel($orcamento);

    expect($dto->numero)->toBe('ORC-001')
        ->and($dto->defeito_relatado)->toBe('Reparo de computador')
        ->and($dto->valor_total)->toBe(150.00)
        ->and($dto->status)->toBe(OrcamentoStatus::PENDENTE)
        ->and($dto->observacoes)->toBe('Orçamento para cliente VIP');
});

test('deve converter DTO para array', function () {
    $dto = new OrcamentoDTO(
        id: 1,
        cliente_id: 1,
        numero: 'ORC-001',
        defeito_relatado: 'Reparo de computador',
        valor_total: 150.00,
        status: OrcamentoStatus::PENDENTE,
        data_criacao: '2024-01-15',
        data_validade: '2024-02-15',
        observacoes: 'Orçamento para cliente VIP'
    );

    $array = $dto->toArray();

    expect($array)->toBe([
        'id' => 1,
        'cliente_id' => 1,
        'numero' => 'ORC-001',
        'defeito_relatado' => 'Reparo de computador',
        'valor_total' => 150.00,
        'status' => OrcamentoStatus::PENDENTE->value,
        'data_criacao' => '2024-01-15',
        'data_validade' => '2024-02-15',
        'observacoes' => 'Orçamento para cliente VIP',
    ]);
});

test('deve converter DTO para array de resposta com label e cor', function () {
    $dto = new OrcamentoDTO(
        id: 1,
        cliente_id: 1,
        numero: 'ORC-001',
        defeito_relatado: 'Reparo de computador',
        valor_total: 150.00,
        status: OrcamentoStatus::PENDENTE,
        data_criacao: '2024-01-15',
        data_validade: '2024-02-15',
        observacoes: 'Orçamento para cliente VIP'
    );

    $responseArray = $dto->toResponseArray();

    expect($responseArray)->toHaveKey('status_label')
        ->and($responseArray)->toHaveKey('status_color')
        ->and($responseArray['status_label'])->toBe('Pendente')
        ->and($responseArray['status_color'])->toBe('yellow');
});

test('deve definir valores padrão corretamente', function () {
    $request = Request::create('/', 'POST', [
        'cliente_id' => Cliente::factory()->create()->id,
        'numero' => 'ORC-001',
        'defeito_relatado' => 'Reparo de computador',
        'valor_total' => 150.00,
    ]);

    $dto = OrcamentoDTO::fromRequest($request);

    expect($dto->status)->toBe(OrcamentoStatus::PENDENTE)
        ->and($dto->data_criacao)->toBeNull()
        ->and($dto->data_validade)->toBeNull()
        ->and($dto->observacoes)->toBeNull();
});

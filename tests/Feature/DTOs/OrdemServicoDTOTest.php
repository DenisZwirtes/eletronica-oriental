<?php

use App\DTOs\OrdemServicoDTO;
use App\Models\OrdemServico;
use App\Models\Cliente;
use App\Enums\OrdemServicoStatus;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->ordemData = [
        'numero' => 'OS-001',
        'cliente_id' => Cliente::factory()->create()->id,
        'tecnico_id' => null,
        'equipamento' => 'Notebook Dell',
        'marca' => 'Dell',
        'modelo' => 'Inspiron 15',
        'numero_serie' => 'SN123456',
        'defeito_relatado' => 'Não liga',
        'defeito_encontrado' => 'Fonte com problema',
        'solucao_aplicada' => 'Troca da fonte',
        'pecas_utilizadas' => 'Fonte 19V',
        'valor_mao_obra' => 80.00,
        'valor_pecas' => 120.00,
        'valor_total' => 200.00,
        'status' => OrdemServicoStatus::PENDENTE->value,
        'data_entrada' => '2024-01-15',
        'data_saida' => null,
        'garantia_dias' => 90,
        'observacoes' => 'Cliente solicitou urgência',
    ];
});

test('deve criar DTO a partir de request', function () {
    $request = Request::create('/', 'POST', $this->ordemData);

    $dto = OrdemServicoDTO::fromRequest($request);

    expect($dto->numero)->toBe('OS-001')
        ->and($dto->cliente_id)->toBe($this->ordemData['cliente_id'])
        ->and($dto->equipamento)->toBe('Notebook Dell')
        ->and($dto->marca)->toBe('Dell')
        ->and($dto->modelo)->toBe('Inspiron 15')
        ->and($dto->numero_serie)->toBe('SN123456')
        ->and($dto->defeito_relatado)->toBe('Não liga')
        ->and($dto->defeito_encontrado)->toBe('Fonte com problema')
        ->and($dto->solucao_aplicada)->toBe('Troca da fonte')
        ->and($dto->pecas_utilizadas)->toBe('Fonte 19V')
        ->and($dto->valor_mao_obra)->toBe(80.00)
        ->and($dto->valor_pecas)->toBe(120.00)
        ->and($dto->valor_total)->toBe(200.00)
        ->and($dto->status)->toBe(OrdemServicoStatus::PENDENTE)
        ->and($dto->data_entrada)->toBe('2024-01-15')
        ->and($dto->data_saida)->toBeNull()
        ->and($dto->garantia_dias)->toBe(90)
        ->and($dto->observacoes)->toBe('Cliente solicitou urgência');
});

test('deve criar DTO a partir de modelo', function () {
    $ordem = OrdemServico::factory()->create($this->ordemData);

    $dto = OrdemServicoDTO::fromModel($ordem);

    expect($dto->numero)->toBe('OS-001')
        ->and($dto->equipamento)->toBe('Notebook Dell')
        ->and($dto->marca)->toBe('Dell')
        ->and($dto->modelo)->toBe('Inspiron 15')
        ->and($dto->defeito_relatado)->toBe('Não liga')
        ->and($dto->valor_total)->toBe(200.00)
        ->and($dto->status)->toBe(OrdemServicoStatus::PENDENTE);
});

test('deve converter DTO para array', function () {
    $dto = new OrdemServicoDTO(
        id: 1,
        numero: 'OS-001',
        cliente_id: 1,
        tecnico_id: null,
        equipamento: 'Notebook Dell',
        marca: 'Dell',
        modelo: 'Inspiron 15',
        numero_serie: 'SN123456',
        defeito_relatado: 'Não liga',
        defeito_encontrado: 'Fonte com problema',
        solucao_aplicada: 'Troca da fonte',
        pecas_utilizadas: 'Fonte 19V',
        valor_mao_obra: 80.00,
        valor_pecas: 120.00,
        valor_total: 200.00,
        status: OrdemServicoStatus::PENDENTE,
        data_entrada: '2024-01-15',
        data_saida: null,
        garantia_dias: 90,
        observacoes: 'Cliente solicitou urgência'
    );

    $array = $dto->toArray();

    expect($array)->toBe([
        'id' => 1,
        'numero' => 'OS-001',
        'cliente_id' => 1,
        'tecnico_id' => null,
        'equipamento' => 'Notebook Dell',
        'marca' => 'Dell',
        'modelo' => 'Inspiron 15',
        'numero_serie' => 'SN123456',
        'defeito_relatado' => 'Não liga',
        'defeito_encontrado' => 'Fonte com problema',
        'solucao_aplicada' => 'Troca da fonte',
        'pecas_utilizadas' => 'Fonte 19V',
        'valor_mao_obra' => 80.00,
        'valor_pecas' => 120.00,
        'valor_total' => 200.00,
        'status' => OrdemServicoStatus::PENDENTE->value,
        'data_entrada' => '2024-01-15',
        'data_saida' => null,
        'garantia_dias' => 90,
        'observacoes' => 'Cliente solicitou urgência',
    ]);
});

test('deve converter DTO para array de resposta com label e cor', function () {
    $dto = new OrdemServicoDTO(
        id: 1,
        numero: 'OS-001',
        cliente_id: 1,
        tecnico_id: null,
        equipamento: 'Notebook Dell',
        marca: 'Dell',
        modelo: 'Inspiron 15',
        numero_serie: 'SN123456',
        defeito_relatado: 'Não liga',
        defeito_encontrado: 'Fonte com problema',
        solucao_aplicada: 'Troca da fonte',
        pecas_utilizadas: 'Fonte 19V',
        valor_mao_obra: 80.00,
        valor_pecas: 120.00,
        valor_total: 200.00,
        status: OrdemServicoStatus::PENDENTE,
        data_entrada: '2024-01-15',
        data_saida: null,
        garantia_dias: 90,
        observacoes: 'Cliente solicitou urgência'
    );

    $responseArray = $dto->toResponseArray();

    expect($responseArray)->toHaveKey('status_label')
        ->and($responseArray)->toHaveKey('status_color')
        ->and($responseArray['status_label'])->toBe('Pendente')
        ->and($responseArray['status_color'])->toBe('yellow');
});

test('deve definir valores padrão corretamente', function () {
    $request = Request::create('/', 'POST', [
        'numero' => 'OS-001',
        'cliente_id' => Cliente::factory()->create()->id,
        'equipamento' => 'Notebook Dell',
        'marca' => 'Dell',
        'modelo' => 'Inspiron 15',
        'defeito_relatado' => 'Não liga',
        'valor_mao_obra' => 80.00,
        'valor_pecas' => 120.00,
        'valor_total' => 200.00,
    ]);

    $dto = OrdemServicoDTO::fromRequest($request);

    expect($dto->status)->toBe(OrdemServicoStatus::PENDENTE)
        ->and($dto->tecnico_id)->toBeNull()
        ->and($dto->numero_serie)->toBeNull()
        ->and($dto->defeito_encontrado)->toBeNull()
        ->and($dto->solucao_aplicada)->toBeNull()
        ->and($dto->pecas_utilizadas)->toBeNull()
        ->and($dto->data_entrada)->toBeNull()
        ->and($dto->data_saida)->toBeNull()
        ->and($dto->garantia_dias)->toBeNull()
        ->and($dto->observacoes)->toBeNull();
});

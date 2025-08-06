<?php

use App\Models\Orcamento;
use App\Models\OrdemServico;
use App\Enums\OrcamentoStatus;
use App\Enums\OrdemServicoStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->orcamento = Orcamento::factory()->create([
        'status' => OrcamentoStatus::PENDENTE->value
    ]);

    $this->ordemServico = OrdemServico::factory()->create([
        'status' => OrdemServicoStatus::PENDENTE->value
    ]);
});

test('deve verificar se status está ativo', function () {
    expect($this->orcamento->isStatusActive())->toBeTrue();

    $this->orcamento->update(['status' => OrcamentoStatus::REJEITADO->value]);

    expect($this->orcamento->isStatusActive())->toBeFalse();
});

test('deve retornar cor do status', function () {
    expect($this->orcamento->getStatusColor())->toBe('yellow');

    $this->orcamento->update(['status' => OrcamentoStatus::APROVADO->value]);

    expect($this->orcamento->getStatusColor())->toBe('green');
});

test('deve retornar enum do status', function () {
    $statusEnum = $this->orcamento->getStatusEnum();

    expect($statusEnum)->toBe(OrcamentoStatus::PENDENTE);
});

test('deve atualizar status', function () {
    $result = $this->orcamento->updateStatus(OrcamentoStatus::APROVADO->value);

    expect($result)->toBeTrue()
        ->and($this->orcamento->fresh()->status)->toBe(OrcamentoStatus::APROVADO->value);
});

test('deve marcar orçamento como pendente', function () {
    $this->orcamento->update(['status' => OrcamentoStatus::APROVADO->value]);

    $this->orcamento->markAsPending();

    expect($this->orcamento->fresh()->status)->toBe(OrcamentoStatus::PENDENTE->value);
});

test('deve marcar orçamento como aprovado', function () {
    $this->orcamento->markAsApproved();

    expect($this->orcamento->fresh()->status)->toBe(OrcamentoStatus::APROVADO->value);
});

test('deve marcar orçamento como rejeitado', function () {
    $this->orcamento->markAsRejected();

    expect($this->orcamento->fresh()->status)->toBe(OrcamentoStatus::REJEITADO->value);
});

test('deve marcar orçamento como convertido', function () {
    $this->orcamento->update(['status' => OrcamentoStatus::APROVADO->value]);

    $this->orcamento->markAsConverted();

    expect($this->orcamento->fresh()->status)->toBe(OrcamentoStatus::CONVERTIDO->value);
});

test('deve marcar ordem de serviço como pendente', function () {
    $this->ordemServico->update(['status' => OrdemServicoStatus::EM_ANDAMENTO->value]);

    $this->ordemServico->markAsPending();

    expect($this->ordemServico->fresh()->status)->toBe(OrdemServicoStatus::PENDENTE->value);
});

test('deve marcar ordem de serviço como em andamento', function () {
    $this->ordemServico->markAsInProgress();

    expect($this->ordemServico->fresh()->status)->toBe(OrdemServicoStatus::EM_ANDAMENTO->value);
});

test('deve marcar ordem de serviço como concluída', function () {
    $this->ordemServico->update(['status' => OrdemServicoStatus::EM_ANDAMENTO->value]);

    $this->ordemServico->markAsCompleted();

    expect($this->ordemServico->fresh()->status)->toBe(OrdemServicoStatus::CONCLUIDA->value);
});

test('deve marcar ordem de serviço como cancelada', function () {
    $this->ordemServico->markAsCancelled();

    expect($this->ordemServico->fresh()->status)->toBe(OrdemServicoStatus::CANCELADA->value);
});

test('deve verificar se pode ser editado', function () {
    expect($this->orcamento->canEdit())->toBeTrue();

    $this->orcamento->update(['status' => OrcamentoStatus::REJEITADO->value]);

    expect($this->orcamento->canEdit())->toBeFalse();
});

test('deve verificar se pode ser cancelado', function () {
    expect($this->orcamento->canCancel())->toBeTrue();

    $this->orcamento->update(['status' => OrcamentoStatus::REJEITADO->value]);

    expect($this->orcamento->canCancel())->toBeFalse();
});

test('deve retornar label do status', function () {
    expect($this->orcamento->getStatusDisplayLabel())->toBe('Pendente');

    $this->orcamento->update(['status' => OrcamentoStatus::APROVADO->value]);

    expect($this->orcamento->getStatusDisplayLabel())->toBe('Aprovado');
});

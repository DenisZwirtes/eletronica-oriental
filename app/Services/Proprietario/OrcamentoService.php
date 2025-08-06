<?php

namespace App\Services\Proprietario;

use App\DTOs\OrcamentoDTO;
use App\Models\Orcamento;
use Illuminate\Database\Eloquent\Collection;

class OrcamentoService
{
    public function listar(): array
    {
        return Orcamento::all()->map(fn($orcamento) => OrcamentoDTO::fromModel($orcamento)->toResponseArray())->toArray();
    }

    public function criar(OrcamentoDTO $dto): array
    {
        $orcamento = Orcamento::create($dto->toArray());
        return OrcamentoDTO::fromModel($orcamento)->toResponseArray();
    }

    public function atualizar(Orcamento $orcamento, OrcamentoDTO $dto): array
    {
        $orcamento->update($dto->toArray());
        return OrcamentoDTO::fromModel($orcamento)->toResponseArray();
    }

    public function excluir(Orcamento $orcamento): bool
    {
        return $orcamento->delete();
    }

    public function buscarPorId(int $id): ?array
    {
        $orcamento = Orcamento::find($id);
        return $orcamento ? OrcamentoDTO::fromModel($orcamento)->toResponseArray() : null;
    }
}

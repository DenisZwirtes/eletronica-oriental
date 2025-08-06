<?php

namespace App\Services\Proprietario;

use App\DTOs\OrdemServicoDTO;
use App\Models\OrdemServico;
use Illuminate\Database\Eloquent\Collection;

class OrdemServicoService
{
    public function listar(): array
    {
        return OrdemServico::all()->map(fn($ordem) => OrdemServicoDTO::fromModel($ordem)->toResponseArray())->toArray();
    }

    public function criar(OrdemServicoDTO $dto): array
    {
        $ordem = OrdemServico::create($dto->toArray());
        return OrdemServicoDTO::fromModel($ordem)->toResponseArray();
    }

    public function atualizar(OrdemServico $ordem, OrdemServicoDTO $dto): array
    {
        $ordem->update($dto->toArray());
        return OrdemServicoDTO::fromModel($ordem)->toResponseArray();
    }

    public function excluir(OrdemServico $ordem): bool
    {
        return $ordem->delete();
    }

    public function buscarPorId(int $id): ?array
    {
        $ordem = OrdemServico::find($id);
        return $ordem ? OrdemServicoDTO::fromModel($ordem)->toResponseArray() : null;
    }
}

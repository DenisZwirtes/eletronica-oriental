<?php

namespace App\Http\Controllers\Proprietario;

use App\Http\Controllers\Controller;
use App\Services\Proprietario\OrdemServicoService;
use App\DTOs\OrdemServicoDTO;
use App\Http\Requests\OrdemServicoRequest;
use App\Models\OrdemServico;
use Illuminate\Http\Response;

class OrdemServicoController extends Controller
{
    public function __construct(private OrdemServicoService $service) {}

    public function index()
    {
        return response()->json($this->service->listar());
    }

    public function store(OrdemServicoRequest $request)
    {
        $dto = OrdemServicoDTO::fromRequest($request);
        $ordem = $this->service->criar($dto);
        return response()->json($ordem, Response::HTTP_CREATED);
    }

    public function show(OrdemServico $ordemServico)
    {
        return response()->json($this->service->buscarPorId($ordemServico->id));
    }

    public function update(OrdemServicoRequest $request, OrdemServico $ordemServico)
    {
        $dto = OrdemServicoDTO::fromRequest($request);
        $ordem = $this->service->atualizar($ordemServico, $dto);
        return response()->json($ordem);
    }

    public function destroy(OrdemServico $ordemServico)
    {
        $this->service->excluir($ordemServico);
        return response()->noContent();
    }
}

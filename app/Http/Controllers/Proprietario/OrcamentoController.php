<?php

namespace App\Http\Controllers\Proprietario;

use App\Http\Controllers\Controller;
use App\Services\Proprietario\OrcamentoService;
use App\DTOs\OrcamentoDTO;
use App\Http\Requests\OrcamentoRequest;
use App\Models\Orcamento;
use Illuminate\Http\Response;

class OrcamentoController extends Controller
{
    public function __construct(private OrcamentoService $service) {}

    public function index()
    {
        return response()->json($this->service->listar());
    }

    public function store(OrcamentoRequest $request)
    {
        $dto = OrcamentoDTO::fromRequest($request);
        $orcamento = $this->service->criar($dto);
        return response()->json($orcamento, Response::HTTP_CREATED);
    }

    public function show(Orcamento $orcamento)
    {
        return response()->json($this->service->buscarPorId($orcamento->id));
    }

    public function update(OrcamentoRequest $request, Orcamento $orcamento)
    {
        $dto = OrcamentoDTO::fromRequest($request);
        $orcamento = $this->service->atualizar($orcamento, $dto);
        return response()->json($orcamento);
    }

    public function destroy(Orcamento $orcamento)
    {
        $this->service->excluir($orcamento);
        return response()->noContent();
    }
}

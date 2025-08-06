<?php

namespace App\Http\Controllers\Proprietario;

use App\Http\Controllers\Controller;
use App\Services\Proprietario\ClienteService;
use App\DTOs\ClienteDTO;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Response;

class ClienteController extends Controller
{
    public function __construct(private ClienteService $service) {}

    public function index()
    {
        return response()->json($this->service->listar());
    }

    public function store(ClienteRequest $request)
    {
        $dto = ClienteDTO::fromRequest($request);
        $cliente = $this->service->criar($dto);
        return response()->json($cliente, Response::HTTP_CREATED);
    }

    public function show(Cliente $cliente)
    {
        return response()->json($this->service->buscarPorId($cliente->id));
    }

    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $dto = ClienteDTO::fromRequest($request);
        $cliente = $this->service->atualizar($cliente, $dto);
        return response()->json($cliente);
    }

    public function destroy(Cliente $cliente)
    {
        $this->service->excluir($cliente);
        return response()->noContent();
    }
}

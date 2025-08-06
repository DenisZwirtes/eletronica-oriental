<?php

namespace App\Services\Proprietario;

use App\DTOs\ClienteDTO;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Collection;

class ClienteService
{
    /**
     * Lista todos os clientes
     */
    public function listar(): Collection
    {
        return Cliente::all();
    }

    /**
     * Cria um novo cliente
     */
    public function criar(ClienteDTO $dto): Cliente
    {
        return Cliente::create($dto->toArray());
    }

    /**
     * Atualiza um cliente existente
     */
    public function atualizar(Cliente $cliente, ClienteDTO $dto): Cliente
    {
        $cliente->update($dto->toArray());
        return $cliente;
    }

    /**
     * Exclui um cliente
     */
    public function excluir(Cliente $cliente): bool
    {
        return $cliente->delete();
    }

    /**
     * Busca um cliente por ID
     */
    public function buscarPorId(int $id): ?Cliente
    {
        return Cliente::find($id);
    }
}

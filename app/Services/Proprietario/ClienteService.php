<?php

namespace App\Services\Proprietario;

use App\Models\Cliente;
use App\DTOs\ClienteDTO;
use App\Services\Common\ActivityLoggerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClienteService
{
    public function __construct(
        private ActivityLoggerService $activityLogger
    ) {}

    /**
     * Lista todos os clientes com paginação.
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listarClientes(int $perPage = 15)
    {
        return Cliente::query()
            ->orderBy('nome')
            ->paginate($perPage);
    }

    /**
     * Busca clientes por termo de pesquisa.
     *
     * @param string $termo
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function buscarClientes(string $termo, int $perPage = 15)
    {
        return Cliente::query()
            ->where('nome', 'like', "%{$termo}%")
            ->orWhere('email', 'like', "%{$termo}%")
            ->orWhere('telefone', 'like', "%{$termo}%")
            ->orWhere('cpf_cnpj', 'like', "%{$termo}%")
            ->orderBy('nome')
            ->paginate($perPage);
    }

    /**
     * Cria um novo cliente usando DTO.
     *
     * @param ClienteDTO $dto
     * @return Cliente
     */
    public function criarCliente(ClienteDTO $dto): Cliente
    {
        try {
            DB::beginTransaction();

            $cliente = Cliente::create($dto->toArray());

            $this->activityLogger->logCreate(
                'cliente',
                "Cliente '{$cliente->nome}' criado com sucesso",
                ['cliente_id' => $cliente->id]
            );

            DB::commit();

            return $cliente;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar cliente: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Atualiza um cliente existente usando DTO.
     *
     * @param int $id
     * @param ClienteDTO $dto
     * @return Cliente
     */
    public function atualizarCliente(int $id, ClienteDTO $dto): Cliente
    {
        try {
            DB::beginTransaction();

            $cliente = Cliente::findOrFail($id);
            $cliente->update($dto->toArray());

            $this->activityLogger->logUpdate(
                'cliente',
                "Cliente '{$cliente->nome}' atualizado com sucesso",
                ['cliente_id' => $cliente->id]
            );

            DB::commit();

            return $cliente;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar cliente: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Exclui um cliente.
     *
     * @param int $id
     * @return bool
     */
    public function excluirCliente(int $id): bool
    {
        try {
            DB::beginTransaction();

            $cliente = Cliente::findOrFail($id);
            $nomeCliente = $cliente->nome;
            
            $cliente->delete();

            $this->activityLogger->logDelete(
                'cliente',
                "Cliente '{$nomeCliente}' excluído com sucesso",
                ['cliente_id' => $id]
            );

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir cliente: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Busca um cliente por ID.
     *
     * @param int $id
     * @return Cliente
     */
    public function buscarCliente(int $id): Cliente
    {
        return Cliente::findOrFail($id);
    }

    /**
     * Ativa/desativa um cliente.
     *
     * @param int $id
     * @return Cliente
     */
    public function toggleStatus(int $id): Cliente
    {
        try {
            DB::beginTransaction();

            $cliente = Cliente::findOrFail($id);
            $cliente->ativo = !$cliente->ativo;
            $cliente->save();

            $acao = $cliente->ativo ? 'ativado' : 'desativado';
            $this->activityLogger->logUpdate(
                'cliente',
                "Cliente '{$cliente->nome}' {$acao}",
                ['cliente_id' => $cliente->id]
            );

            DB::commit();

            return $cliente;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao alterar status do cliente: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Obtém estatísticas dos clientes.
     *
     * @return array
     */
    public function getEstatisticas(): array
    {
        return [
            'total' => Cliente::count(),
            'ativos' => Cliente::where('ativo', true)->count(),
            'inativos' => Cliente::where('ativo', false)->count(),
            'novos_mes' => Cliente::whereMonth('created_at', now()->month)->count(),
        ];
    }
}

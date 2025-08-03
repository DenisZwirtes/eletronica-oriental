<?php

namespace App\Services\Proprietario;

use App\Models\Cliente;
use App\Services\Common\ActivityLoggerService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ClienteService
{
    public function __construct(
        private ActivityLoggerService $activityLogger
    ) {}

    /**
     * Lista todos os clientes com paginação
     */
    public function listarClientes(int $perPage = 15): LengthAwarePaginator
    {
        return Cliente::with(['ordensServico', 'orcamentos'])
            ->orderBy('nome')
            ->paginate($perPage);
    }

    /**
     * Busca clientes por termo
     */
    public function buscarClientes(string $termo, int $perPage = 15): LengthAwarePaginator
    {
        return Cliente::where('nome', 'like', "%{$termo}%")
            ->orWhere('email', 'like', "%{$termo}%")
            ->orWhere('telefone', 'like', "%{$termo}%")
            ->orWhere('cpf_cnpj', 'like', "%{$termo}%")
            ->with(['ordensServico', 'orcamentos'])
            ->orderBy('nome')
            ->paginate($perPage);
    }

    /**
     * Cria um novo cliente
     */
    public function criarCliente(array $dados): Cliente
    {
        $cliente = Cliente::create([
            'nome' => $dados['nome'],
            'email' => $dados['email'],
            'telefone' => $dados['telefone'],
            'cpf_cnpj' => $dados['cpf_cnpj'] ?? null,
            'endereco' => $dados['endereco'] ?? null,
            'cidade' => $dados['cidade'] ?? null,
            'estado' => $dados['estado'] ?? null,
            'cep' => $dados['cep'] ?? null,
            'observacoes' => $dados['observacoes'] ?? null,
        ]);

        $this->activityLogger->logCreate(
            'Cliente',
            "Cliente {$cliente->nome} criado"
        );

        return $cliente;
    }

    /**
     * Atualiza um cliente
     */
    public function atualizarCliente(Cliente $cliente, array $dados): bool
    {
        $nomeAnterior = $cliente->nome;

        $cliente->update([
            'nome' => $dados['nome'],
            'email' => $dados['email'],
            'telefone' => $dados['telefone'],
            'cpf_cnpj' => $dados['cpf_cnpj'] ?? null,
            'endereco' => $dados['endereco'] ?? null,
            'cidade' => $dados['cidade'] ?? null,
            'estado' => $dados['estado'] ?? null,
            'cep' => $dados['cep'] ?? null,
            'observacoes' => $dados['observacoes'] ?? null,
        ]);

        $this->activityLogger->logUpdate(
            'Cliente',
            "Cliente {$nomeAnterior} atualizado"
        );

        return true;
    }

    /**
     * Exclui um cliente
     */
    public function excluirCliente(Cliente $cliente): bool
    {
        $nome = $cliente->nome;

        $cliente->delete();

        $this->activityLogger->logDelete(
            'Cliente',
            "Cliente {$nome} excluído"
        );

        return true;
    }

    /**
     * Obtém cliente por ID
     */
    public function obterCliente(int $id): ?Cliente
    {
        return Cliente::with(['ordensServico', 'orcamentos'])->find($id);
    }

    /**
     * Obtém estatísticas dos clientes
     */
    public function obterEstatisticas(): array
    {
        return [
            'total' => Cliente::count(),
            'ativos' => Cliente::where('ativo', true)->count(),
            'inativos' => Cliente::where('ativo', false)->count(),
            'com_ordens' => Cliente::has('ordensServico')->count(),
            'sem_ordens' => Cliente::doesntHave('ordensServico')->count(),
        ];
    }

    /**
     * Obtém clientes mais ativos
     */
    public function obterClientesMaisAtivos(int $limit = 10): Collection
    {
        return Cliente::withCount('ordensServico')
            ->orderBy('ordens_servico_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Verifica se CPF/CNPJ já existe
     */
    public function cpfCnpjExiste(string $cpfCnpj, ?Cliente $excludeCliente = null): bool
    {
        $query = Cliente::where('cpf_cnpj', $cpfCnpj);

        if ($excludeCliente) {
            $query->where('id', '!=', $excludeCliente->id);
        }

        return $query->exists();
    }

    /**
     * Verifica se email já existe
     */
    public function emailExiste(string $email, ?Cliente $excludeCliente = null): bool
    {
        $query = Cliente::where('email', $email);

        if ($excludeCliente) {
            $query->where('id', '!=', $excludeCliente->id);
        }

        return $query->exists();
    }
}

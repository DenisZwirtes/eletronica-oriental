<?php

namespace App\Services\Atendente;

use App\Models\Cliente;
use App\Models\Orcamento;
use App\Models\User;
use App\Services\Common\ActivityLoggerService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AtendimentoService
{
    public function __construct(
        private ActivityLoggerService $activityLogger
    ) {}

    /**
     * Busca cliente por termo
     */
    public function buscarCliente(string $termo): ?Cliente
    {
        return Cliente::where('nome', 'like', "%{$termo}%")
            ->orWhere('email', 'like', "%{$termo}%")
            ->orWhere('telefone', 'like', "%{$termo}%")
            ->orWhere('cpf_cnpj', 'like', "%{$termo}%")
            ->first();
    }

    /**
     * Lista clientes para atendimento
     */
    public function listarClientesAtendimento(int $perPage = 15): LengthAwarePaginator
    {
        return Cliente::with(['ordensServico', 'orcamentos'])
            ->orderBy('nome')
            ->paginate($perPage);
    }

    /**
     * Obtém histórico do cliente
     */
    public function obterHistoricoCliente(Cliente $cliente): array
    {
        return [
            'ordens_servico' => $cliente->ordensServico()
                ->with(['tecnico'])
                ->orderBy('created_at', 'desc')
                ->get(),
            'orcamentos' => $cliente->orcamentos()
                ->with(['atendente'])
                ->orderBy('created_at', 'desc')
                ->get(),
            'total_gasto' => $cliente->total_gasto,
            'quantidade_ordens' => $cliente->quantidade_ordens,
            'quantidade_orcamentos' => $cliente->quantidade_orcamentos,
        ];
    }

    /**
     * Registra atendimento
     */
    public function registrarAtendimento(Cliente $cliente, User $atendente, array $dados): bool
    {
        $this->activityLogger->log(
            'atendimento_registrado',
            "Atendente {$atendente->name} registrou atendimento para cliente {$cliente->nome}",
            $atendente,
            [
                'cliente_id' => $cliente->id,
                'tipo_atendimento' => $dados['tipo_atendimento'] ?? 'geral',
                'observacoes' => $dados['observacoes'] ?? null,
            ]
        );

        return true;
    }

    /**
     * Obtém estatísticas de atendimento
     */
    public function obterEstatisticasAtendimento(User $atendente): array
    {
        $orcamentos = Orcamento::where('atendente_id', $atendente->id);

        return [
            'orcamentos_criados' => $orcamentos->count(),
            'orcamentos_pendentes' => $orcamentos->where('status', 'pendente')->count(),
            'orcamentos_aprovados' => $orcamentos->where('status', 'aprovado')->count(),
            'orcamentos_rejeitados' => $orcamentos->where('status', 'rejeitado')->count(),
            'valor_total_orcamentos' => $orcamentos->where('status', 'aprovado')->sum('valor_total'),
        ];
    }

    /**
     * Obtém atendimentos recentes
     */
    public function obterAtendimentosRecentes(User $atendente, int $limit = 10): Collection
    {
        // Aqui você pode implementar um sistema de log específico para atendimentos
        // Por enquanto, retornamos orçamentos criados pelo atendente
        return Orcamento::where('atendente_id', $atendente->id)
            ->with(['cliente'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Verifica se cliente tem pendências
     */
    public function verificarPendenciasCliente(Cliente $cliente): array
    {
        $pendencias = [];

        // Verifica orçamentos pendentes
        $orcamentosPendentes = $cliente->orcamentos()
            ->where('status', 'pendente')
            ->where('data_validade', '>=', now())
            ->count();

        if ($orcamentosPendentes > 0) {
            $pendencias[] = "Cliente possui {$orcamentosPendentes} orçamento(s) pendente(s)";
        }

        // Verifica orçamentos vencidos
        $orcamentosVencidos = $cliente->orcamentos()
            ->where('status', 'pendente')
            ->where('data_validade', '<', now())
            ->count();

        if ($orcamentosVencidos > 0) {
            $pendencias[] = "Cliente possui {$orcamentosVencidos} orçamento(s) vencido(s)";
        }

        // Verifica ordens de serviço em andamento
        $ordensEmAndamento = $cliente->ordensServico()
            ->where('status', 'em_andamento')
            ->count();

        if ($ordensEmAndamento > 0) {
            $pendencias[] = "Cliente possui {$ordensEmAndamento} ordem(s) de serviço em andamento";
        }

        return $pendencias;
    }

    /**
     * Obtém sugestões de atendimento
     */
    public function obterSugestoesAtendimento(Cliente $cliente): array
    {
        $sugestoes = [];

        // Se cliente não tem histórico, sugerir primeiro atendimento
        if (!$cliente->temOrdensServico() && !$cliente->temOrcamentos()) {
            $sugestoes[] = "Primeiro atendimento - Apresentar serviços disponíveis";
        }

        // Se cliente tem orçamentos aprovados, sugerir criar ordem de serviço
        $orcamentosAprovados = $cliente->orcamentos()
            ->where('status', 'aprovado')
            ->count();

        if ($orcamentosAprovados > 0) {
            $sugestoes[] = "Cliente possui orçamentos aprovados - Verificar se deseja criar ordem de serviço";
        }

        // Se cliente tem histórico de consertos, sugerir manutenção preventiva
        $ordensConcluidas = $cliente->ordensServico()
            ->where('status', 'concluida')
            ->count();

        if ($ordensConcluidas > 3) {
            $sugestoes[] = "Cliente frequente - Oferecer manutenção preventiva";
        }

        return $sugestoes;
    }
}

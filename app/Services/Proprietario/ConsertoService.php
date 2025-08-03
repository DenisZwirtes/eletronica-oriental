<?php

namespace App\Services\Proprietario;

use App\Models\OrdemServico;
use App\Models\User;
use App\Services\Common\ActivityLoggerService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ConsertoService
{
    public function __construct(
        private ActivityLoggerService $activityLogger
    ) {}

    /**
     * Lista todos os consertos
     */
    public function listarConsertos(int $perPage = 15): LengthAwarePaginator
    {
        return OrdemServico::with(['cliente', 'tecnico'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Lista consertos por status
     */
    public function listarConsertosPorStatus(string $status, int $perPage = 15): LengthAwarePaginator
    {
        return OrdemServico::where('status', $status)
            ->with(['cliente', 'tecnico'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Obtém conserto por ID
     */
    public function obterConserto(int $id): ?OrdemServico
    {
        return OrdemServico::with(['cliente', 'tecnico', 'itens'])->find($id);
    }

    /**
     * Inicia um conserto
     */
    public function iniciarConserto(OrdemServico $ordem, User $proprietario): bool
    {
        $ordem->update([
            'status' => 'em_andamento',
            'tecnico_id' => $proprietario->id,
        ]);

        $this->activityLogger->log(
            'conserto_iniciado',
            "Proprietário {$proprietario->name} iniciou conserto da ordem {$ordem->numero}",
            $proprietario
        );

        return true;
    }

    /**
     * Atualiza diagnóstico do conserto
     */
    public function atualizarDiagnostico(OrdemServico $ordem, string $defeitoEncontrado, User $proprietario): bool
    {
        $ordem->update([
            'defeito_encontrado' => $defeitoEncontrado,
        ]);

        $this->activityLogger->log(
            'diagnostico_atualizado',
            "Proprietário {$proprietario->name} atualizou diagnóstico da ordem {$ordem->numero}",
            $proprietario
        );

        return true;
    }

    /**
     * Aplica solução no conserto
     */
    public function aplicarSolucao(OrdemServico $ordem, array $dados, User $proprietario): bool
    {
        $ordem->update([
            'solucao_aplicada' => $dados['solucao_aplicada'],
            'pecas_utilizadas' => $dados['pecas_utilizadas'] ?? null,
            'valor_mao_obra' => $dados['valor_mao_obra'],
            'valor_pecas' => $dados['valor_pecas'] ?? 0,
            'valor_total' => $dados['valor_mao_obra'] + ($dados['valor_pecas'] ?? 0),
            'garantia_dias' => $dados['garantia_dias'] ?? 0,
        ]);

        $this->activityLogger->log(
            'solucao_aplicada',
            "Proprietário {$proprietario->name} aplicou solução na ordem {$ordem->numero}",
            $proprietario
        );

        return true;
    }

    /**
     * Finaliza um conserto
     */
    public function finalizarConserto(OrdemServico $ordem, User $proprietario): bool
    {
        $ordem->update([
            'status' => 'concluida',
            'data_saida' => now(),
        ]);

        $this->activityLogger->log(
            'conserto_finalizado',
            "Proprietário {$proprietario->name} finalizou conserto da ordem {$ordem->numero}",
            $proprietario
        );

        return true;
    }

    /**
     * Cancela um conserto
     */
    public function cancelarConserto(OrdemServico $ordem, string $motivo, User $proprietario): bool
    {
        $ordem->update([
            'status' => 'cancelada',
            'observacoes' => $ordem->observacoes . "\n\nCancelado em: " . now() . "\nMotivo: " . $motivo,
        ]);

        $this->activityLogger->log(
            'conserto_cancelado',
            "Proprietário {$proprietario->name} cancelou conserto da ordem {$ordem->numero}. Motivo: {$motivo}",
            $proprietario
        );

        return true;
    }

    /**
     * Obtém estatísticas gerais
     */
    public function obterEstatisticas(): array
    {
        $ordens = OrdemServico::query();

        return [
            'total' => $ordens->count(),
            'pendentes' => $ordens->where('status', 'pendente')->count(),
            'em_andamento' => $ordens->where('status', 'em_andamento')->count(),
            'concluidas' => $ordens->where('status', 'concluida')->count(),
            'canceladas' => $ordens->where('status', 'cancelada')->count(),
            'valor_total' => $ordens->where('status', 'concluida')->sum('valor_total'),
            'media_valor' => $ordens->where('status', 'concluida')->avg('valor_total'),
        ];
    }

    /**
     * Obtém consertos recentes
     */
    public function obterConsertosRecentes(int $limit = 10): Collection
    {
        return OrdemServico::with(['cliente', 'tecnico'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtém consertos em garantia
     */
    public function obterConsertosEmGarantia(): Collection
    {
        return OrdemServico::where('status', 'concluida')
            ->whereNotNull('data_saida')
            ->where('garantia_dias', '>', 0)
            ->with(['cliente', 'tecnico'])
            ->get()
            ->filter(function ($ordem) {
                return $ordem->estaEmGarantia();
            });
    }
}

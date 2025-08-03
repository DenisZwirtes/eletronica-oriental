<?php

namespace App\Services\Dashboards;

use App\Models\Cliente;
use App\Models\OrdemServico;
use App\Models\Orcamento;
use App\Models\User;
use App\Services\Common\CacheService;
use Carbon\Carbon;

class ProprietarioDashboardService
{
    public function __construct(
        private CacheService $cacheService
    ) {}

    /**
     * Obtém dados do dashboard do proprietário
     */
    public function obterDadosDashboard(): array
    {
        return $this->cacheService->getDashboardData('proprietario', function () {
            return [
                'resumo_geral' => $this->obterResumoGeral(),
                'estatisticas_mensais' => $this->obterEstatisticasMensais(),
                'top_clientes' => $this->obterTopClientes(),
                'ordens_recentes' => $this->obterOrdensRecentes(),
                'orcamentos_recentes' => $this->obterOrcamentosRecentes(),
                'receita_periodo' => $this->obterReceitaPeriodo(),
                'equipamentos_mais_consertados' => $this->obterEquipamentosMaisConsertados(),
            ];
        });
    }

    /**
     * Obtém resumo geral
     */
    private function obterResumoGeral(): array
    {
        $hoje = Carbon::today();
        $mesAtual = Carbon::now()->startOfMonth();

        return [
            'total_clientes' => Cliente::count(),
            'clientes_ativos' => Cliente::where('ativo', true)->count(),
            'total_ordens' => OrdemServico::count(),
            'ordens_hoje' => OrdemServico::whereDate('created_at', $hoje)->count(),
            'ordens_mes' => OrdemServico::where('created_at', '>=', $mesAtual)->count(),
            'total_orcamentos' => Orcamento::count(),
            'orcamentos_hoje' => Orcamento::whereDate('created_at', $hoje)->count(),
            'orcamentos_mes' => Orcamento::where('created_at', '>=', $mesAtual)->count(),
            'receita_mes' => OrdemServico::where('status', 'concluida')
                ->where('created_at', '>=', $mesAtual)
                ->sum('valor_total'),
        ];
    }

    /**
     * Obtém estatísticas mensais
     */
    private function obterEstatisticasMensais(): array
    {
        $meses = [];
        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $inicioMes = $data->copy()->startOfMonth();
            $fimMes = $data->copy()->endOfMonth();

            $meses[] = [
                'mes' => $data->format('M/Y'),
                'ordens' => OrdemServico::whereBetween('created_at', [$inicioMes, $fimMes])->count(),
                'orcamentos' => Orcamento::whereBetween('created_at', [$inicioMes, $fimMes])->count(),
                'receita' => OrdemServico::where('status', 'concluida')
                    ->whereBetween('created_at', [$inicioMes, $fimMes])
                    ->sum('valor_total'),
            ];
        }

        return $meses;
    }

    /**
     * Obtém top clientes
     */
    private function obterTopClientes(): array
    {
        return Cliente::withCount('ordensServico')
            ->withSum('ordensServico as total_gasto', 'valor_total')
            ->whereHas('ordensServico', function ($query) {
                $query->where('status', 'concluida');
            })
            ->orderBy('total_gasto', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($cliente) {
                return [
                    'id' => $cliente->id,
                    'nome' => $cliente->nome,
                    'quantidade_ordens' => $cliente->ordens_servico_count,
                    'total_gasto' => $cliente->total_gasto ?? 0,
                ];
            })
            ->toArray();
    }

    /**
     * Obtém ordens recentes
     */
    private function obterOrdensRecentes(): array
    {
        return OrdemServico::with(['cliente', 'tecnico'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($ordem) {
                return [
                    'id' => $ordem->id,
                    'numero' => $ordem->numero,
                    'cliente' => $ordem->cliente->nome,
                    'equipamento' => $ordem->equipamento,
                    'status' => $ordem->status_formatado,
                    'valor_total' => $ordem->valor_total,
                    'data_entrada' => $ordem->data_entrada->format('d/m/Y'),
                ];
            })
            ->toArray();
    }

    /**
     * Obtém orçamentos recentes
     */
    private function obterOrcamentosRecentes(): array
    {
        return Orcamento::with(['cliente', 'atendente'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($orcamento) {
                return [
                    'id' => $orcamento->id,
                    'numero' => $orcamento->numero,
                    'cliente' => $orcamento->cliente->nome,
                    'equipamento' => $orcamento->equipamento,
                    'status' => $orcamento->status_formatado,
                    'valor_total' => $orcamento->valor_total,
                    'data_criacao' => $orcamento->data_criacao->format('d/m/Y'),
                ];
            })
            ->toArray();
    }

    /**
     * Obtém receita por período
     */
    private function obterReceitaPeriodo(): array
    {
        $periodos = [
            'hoje' => Carbon::today(),
            'semana' => Carbon::now()->subWeek(),
            'mes' => Carbon::now()->subMonth(),
            'trimestre' => Carbon::now()->subQuarter(),
        ];

        $receita = [];
        foreach ($periodos as $periodo => $data) {
            $receita[$periodo] = OrdemServico::where('status', 'concluida')
                ->where('created_at', '>=', $data)
                ->sum('valor_total');
        }

        return $receita;
    }

    /**
     * Obtém equipamentos mais consertados
     */
    private function obterEquipamentosMaisConsertados(): array
    {
        return OrdemServico::selectRaw('equipamento, COUNT(*) as quantidade')
            ->where('status', 'concluida')
            ->groupBy('equipamento')
            ->orderBy('quantidade', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'equipamento' => $item->equipamento,
                    'quantidade' => $item->quantidade,
                ];
            })
            ->toArray();
    }

    /**
     * Invalida cache do dashboard
     */
    public function invalidarCache(): void
    {
        $this->cacheService->invalidateDashboardCache();
    }
}

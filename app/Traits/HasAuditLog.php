<?php

namespace App\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait HasAuditLog
{
    use LogsActivity;

    /**
     * Configura as opções de log
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->getLoggableAttributes())
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName($this->getLogName());
    }

    /**
     * Obtém os atributos que devem ser logados
     */
    protected function getLoggableAttributes(): array
    {
        return [
            'nome',
            'email',
            'telefone',
            'endereco',
            'cidade',
            'estado',
            'cep',
            'cpf_cnpj',
            'observacoes',
            'ativo',
            'numero',
            'descricao',
            'valor_total',
            'status',
            'data_criacao',
            'data_validade',
            'cliente_id',
            'tecnico_id',
            'equipamento',
            'marca',
            'modelo',
            'numero_serie',
            'defeito_relatado',
            'defeito_encontrado',
            'solucao_aplicada',
            'pecas_utilizadas',
            'valor_mao_obra',
            'valor_pecas',
            'data_entrada',
            'data_saida',
            'garantia_dias',
        ];
    }

    /**
     * Obtém o nome do log
     */
    protected function getLogName(): string
    {
        return match($this->getTable()) {
            'users' => 'Usuários',
            'clientes' => 'Clientes',
            'orcamentos' => 'Orçamentos',
            'ordens_servico' => 'Ordens de Serviço',
            default => 'Sistema',
        };
    }

    /**
     * Obtém a descrição da atividade
     */
    public function getActivityDescription(string $eventName): string
    {
        $modelName = $this->getModelDisplayName();

        return match($eventName) {
            'created' => "{$modelName} criado",
            'updated' => "{$modelName} atualizado",
            'deleted' => "{$modelName} excluído",
            'restored' => "{$modelName} restaurado",
            default => "Ação realizada em {$modelName}",
        };
    }

    /**
     * Obtém o nome de exibição do modelo
     */
    protected function getModelDisplayName(): string
    {
        return match($this->getTable()) {
            'users' => 'Usuário',
            'clientes' => 'Cliente',
            'orcamentos' => 'Orçamento',
            'ordens_servico' => 'Ordem de Serviço',
            default => 'Registro',
        };
    }

    /**
     * Obtém as propriedades adicionais para o log
     */
    public function getActivityProperties(): array
    {
        $properties = [];

        // Adiciona informações específicas baseadas no tipo de modelo
        if (method_exists($this, 'cliente')) {
            $properties['cliente_nome'] = $this->cliente?->nome ?? 'N/A';
        }

        if (method_exists($this, 'tecnico')) {
            $properties['tecnico_nome'] = $this->tecnico?->name ?? 'N/A';
        }

        if (property_exists($this, 'valor_total')) {
            $properties['valor_formatado'] = 'R$ ' . number_format($this->valor_total, 2, ',', '.');
        }

        if (property_exists($this, 'status')) {
            $properties['status_label'] = $this->getStatusLabel();
        }

        return $properties;
    }

    /**
     * Verifica se o modelo deve ser logado
     */
    public function shouldLogActivity(string $eventName): bool
    {
        // Não loga se o modelo não tem ID (ainda não foi salvo)
        if (!$this->exists) {
            return false;
        }

        // Loga apenas eventos específicos
        return in_array($eventName, ['created', 'updated', 'deleted']);
    }

    /**
     * Obtém o nome da tabela do modelo
     */
    protected function getTableName(): string
    {
        return $this->getTable();
    }

    /**
     * Obtém o label do status (se existir)
     */
    protected function getStatusLabel(): string
    {
        if (!property_exists($this, 'status')) {
            return 'N/A';
        }

        return match($this->status) {
            'pendente' => 'Pendente',
            'em_andamento' => 'Em Andamento',
            'concluida' => 'Concluída',
            'cancelada' => 'Cancelada',
            'aprovado' => 'Aprovado',
            'rejeitado' => 'Rejeitado',
            'convertido' => 'Convertido em OS',
            default => 'Desconhecido',
        };
    }
}

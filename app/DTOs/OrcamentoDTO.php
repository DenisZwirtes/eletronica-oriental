<?php

namespace App\DTOs;

class OrcamentoDTO
{
    public function __construct(
        public int $cliente_id,
        public string $equipamento,
        public string $problema_relatado,
        public ?string $diagnostico_tecnico = null,
        public ?string $solucao_proposta = null,
        public ?string $observacoes = null,
        public string $status = 'pendente',
        public ?string $data_orcamento = null,
        public ?string $data_validade = null,
        public ?float $valor_total = null,
        public ?float $valor_pecas = null,
        public ?float $valor_servico = null,
        public ?string $prazo_entrega = null
    ) {}

    /**
     * Cria um DTO a partir dos dados validados.
     *
     * @param array $validated
     * @return self
     */
    public static function fromValidated(array $validated): self
    {
        return new self(
            cliente_id: $validated['cliente_id'],
            equipamento: $validated['equipamento'],
            problema_relatado: $validated['problema_relatado'],
            diagnostico_tecnico: $validated['diagnostico_tecnico'] ?? null,
            solucao_proposta: $validated['solucao_proposta'] ?? null,
            observacoes: $validated['observacoes'] ?? null,
            status: $validated['status'] ?? 'pendente',
            data_orcamento: $validated['data_orcamento'] ?? now()->format('Y-m-d'),
            data_validade: $validated['data_validade'] ?? null,
            valor_total: $validated['valor_total'] ?? null,
            valor_pecas: $validated['valor_pecas'] ?? null,
            valor_servico: $validated['valor_servico'] ?? null,
            prazo_entrega: $validated['prazo_entrega'] ?? null
        );
    }

    /**
     * Converte o DTO para array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'cliente_id' => $this->cliente_id,
            'equipamento' => $this->equipamento,
            'problema_relatado' => $this->problema_relatado,
            'diagnostico_tecnico' => $this->diagnostico_tecnico,
            'solucao_proposta' => $this->solucao_proposta,
            'observacoes' => $this->observacoes,
            'status' => $this->status,
            'data_orcamento' => $this->data_orcamento,
            'data_validade' => $this->data_validade,
            'valor_total' => $this->valor_total,
            'valor_pecas' => $this->valor_pecas,
            'valor_servico' => $this->valor_servico,
            'prazo_entrega' => $this->prazo_entrega,
        ];
    }

    /**
     * Regras de validação para criação de orçamento.
     *
     * @return array
     */
    public static function rules(): array
    {
        return [
            'cliente_id' => 'required|integer|exists:clientes,id',
            'equipamento' => 'required|string|max:255',
            'problema_relatado' => 'required|string|max:1000',
            'diagnostico_tecnico' => 'nullable|string|max:1000',
            'solucao_proposta' => 'nullable|string|max:1000',
            'observacoes' => 'nullable|string|max:1000',
            'status' => 'required|string|in:pendente,aprovado,rejeitado,convertido',
            'data_orcamento' => 'nullable|date',
            'data_validade' => 'nullable|date|after:data_orcamento',
            'valor_total' => 'nullable|numeric|min:0',
            'valor_pecas' => 'nullable|numeric|min:0',
            'valor_servico' => 'nullable|numeric|min:0',
            'prazo_entrega' => 'nullable|string|max:255',
        ];
    }

    /**
     * Regras de validação para atualização de orçamento.
     *
     * @param int $orcamentoId
     * @return array
     */
    public static function updateRules(int $orcamentoId): array
    {
        return [
            'cliente_id' => 'required|integer|exists:clientes,id',
            'equipamento' => 'required|string|max:255',
            'problema_relatado' => 'required|string|max:1000',
            'diagnostico_tecnico' => 'nullable|string|max:1000',
            'solucao_proposta' => 'nullable|string|max:1000',
            'observacoes' => 'nullable|string|max:1000',
            'status' => 'required|string|in:pendente,aprovado,rejeitado,convertido',
            'data_orcamento' => 'nullable|date',
            'data_validade' => 'nullable|date|after:data_orcamento',
            'valor_total' => 'nullable|numeric|min:0',
            'valor_pecas' => 'nullable|numeric|min:0',
            'valor_servico' => 'nullable|numeric|min:0',
            'prazo_entrega' => 'nullable|string|max:255',
        ];
    }

    /**
     * Mensagens de validação personalizadas.
     *
     * @return array
     */
    public static function messages(): array
    {
        return [
            'cliente_id.required' => 'O cliente é obrigatório.',
            'cliente_id.integer' => 'O ID do cliente deve ser um número inteiro.',
            'cliente_id.exists' => 'O cliente selecionado não existe.',
            'equipamento.required' => 'O equipamento é obrigatório.',
            'equipamento.max' => 'O equipamento não pode ter mais de 255 caracteres.',
            'problema_relatado.required' => 'O problema relatado é obrigatório.',
            'problema_relatado.max' => 'O problema relatado não pode ter mais de 1000 caracteres.',
            'diagnostico_tecnico.max' => 'O diagnóstico técnico não pode ter mais de 1000 caracteres.',
            'solucao_proposta.max' => 'A solução proposta não pode ter mais de 1000 caracteres.',
            'observacoes.max' => 'As observações não podem ter mais de 1000 caracteres.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser: pendente, aprovado, rejeitado ou convertido.',
            'data_orcamento.date' => 'A data do orçamento deve ter um formato válido.',
            'data_validade.date' => 'A data de validade deve ter um formato válido.',
            'data_validade.after' => 'A data de validade deve ser posterior à data do orçamento.',
            'valor_total.numeric' => 'O valor total deve ser um número.',
            'valor_total.min' => 'O valor total não pode ser negativo.',
            'valor_pecas.numeric' => 'O valor das peças deve ser um número.',
            'valor_pecas.min' => 'O valor das peças não pode ser negativo.',
            'valor_servico.numeric' => 'O valor do serviço deve ser um número.',
            'valor_servico.min' => 'O valor do serviço não pode ser negativo.',
            'prazo_entrega.max' => 'O prazo de entrega não pode ter mais de 255 caracteres.',
        ];
    }

    /**
     * Status disponíveis para orçamento.
     *
     * @return array
     */
    public static function statusDisponiveis(): array
    {
        return [
            'pendente' => 'Pendente',
            'aprovado' => 'Aprovado',
            'rejeitado' => 'Rejeitado',
            'convertido' => 'Convertido em OS',
        ];
    }
}

<?php

namespace App\DTOs;

class OrdemServicoDTO
{
    public function __construct(
        public int $cliente_id,
        public string $equipamento,
        public string $problema_relatado,
        public ?string $diagnostico_tecnico = null,
        public ?string $solucao_aplicada = null,
        public ?string $observacoes = null,
        public string $status = 'aberta',
        public ?string $data_entrada = null,
        public ?string $data_saida = null,
        public ?float $valor_total = null,
        public ?float $valor_pecas = null,
        public ?float $valor_servico = null,
        public ?string $garantia = null
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
            solucao_aplicada: $validated['solucao_aplicada'] ?? null,
            observacoes: $validated['observacoes'] ?? null,
            status: $validated['status'] ?? 'aberta',
            data_entrada: $validated['data_entrada'] ?? now()->format('Y-m-d'),
            data_saida: $validated['data_saida'] ?? null,
            valor_total: $validated['valor_total'] ?? null,
            valor_pecas: $validated['valor_pecas'] ?? null,
            valor_servico: $validated['valor_servico'] ?? null,
            garantia: $validated['garantia'] ?? null
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
            'solucao_aplicada' => $this->solucao_aplicada,
            'observacoes' => $this->observacoes,
            'status' => $this->status,
            'data_entrada' => $this->data_entrada,
            'data_saida' => $this->data_saida,
            'valor_total' => $this->valor_total,
            'valor_pecas' => $this->valor_pecas,
            'valor_servico' => $this->valor_servico,
            'garantia' => $this->garantia,
        ];
    }

    /**
     * Regras de validação para criação de ordem de serviço.
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
            'solucao_aplicada' => 'nullable|string|max:1000',
            'observacoes' => 'nullable|string|max:1000',
            'status' => 'required|string|in:aberta,em_andamento,concluida,cancelada',
            'data_entrada' => 'nullable|date',
            'data_saida' => 'nullable|date|after_or_equal:data_entrada',
            'valor_total' => 'nullable|numeric|min:0',
            'valor_pecas' => 'nullable|numeric|min:0',
            'valor_servico' => 'nullable|numeric|min:0',
            'garantia' => 'nullable|string|max:255',
        ];
    }

    /**
     * Regras de validação para atualização de ordem de serviço.
     *
     * @param int $ordemId
     * @return array
     */
    public static function updateRules(int $ordemId): array
    {
        return [
            'cliente_id' => 'required|integer|exists:clientes,id',
            'equipamento' => 'required|string|max:255',
            'problema_relatado' => 'required|string|max:1000',
            'diagnostico_tecnico' => 'nullable|string|max:1000',
            'solucao_aplicada' => 'nullable|string|max:1000',
            'observacoes' => 'nullable|string|max:1000',
            'status' => 'required|string|in:aberta,em_andamento,concluida,cancelada',
            'data_entrada' => 'nullable|date',
            'data_saida' => 'nullable|date|after_or_equal:data_entrada',
            'valor_total' => 'nullable|numeric|min:0',
            'valor_pecas' => 'nullable|numeric|min:0',
            'valor_servico' => 'nullable|numeric|min:0',
            'garantia' => 'nullable|string|max:255',
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
            'solucao_aplicada.max' => 'A solução aplicada não pode ter mais de 1000 caracteres.',
            'observacoes.max' => 'As observações não podem ter mais de 1000 caracteres.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser: aberta, em_andamento, concluida ou cancelada.',
            'data_entrada.date' => 'A data de entrada deve ter um formato válido.',
            'data_saida.date' => 'A data de saída deve ter um formato válido.',
            'data_saida.after_or_equal' => 'A data de saída deve ser igual ou posterior à data de entrada.',
            'valor_total.numeric' => 'O valor total deve ser um número.',
            'valor_total.min' => 'O valor total não pode ser negativo.',
            'valor_pecas.numeric' => 'O valor das peças deve ser um número.',
            'valor_pecas.min' => 'O valor das peças não pode ser negativo.',
            'valor_servico.numeric' => 'O valor do serviço deve ser um número.',
            'valor_servico.min' => 'O valor do serviço não pode ser negativo.',
            'garantia.max' => 'A garantia não pode ter mais de 255 caracteres.',
        ];
    }

    /**
     * Status disponíveis para ordem de serviço.
     *
     * @return array
     */
    public static function statusDisponiveis(): array
    {
        return [
            'aberta' => 'Aberta',
            'em_andamento' => 'Em Andamento',
            'concluida' => 'Concluída',
            'cancelada' => 'Cancelada',
        ];
    }
}

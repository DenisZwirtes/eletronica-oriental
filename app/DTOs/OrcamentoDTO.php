<?php

namespace App\DTOs;

use Illuminate\Http\Request;
use App\Enums\OrcamentoStatus;

class OrcamentoDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $cliente_id,
        public readonly string $numero,
        public readonly string $defeito_relatado,
        public readonly float $valor_total,
        public readonly OrcamentoStatus $status,
        public readonly ?string $data_criacao,
        public readonly ?string $data_validade,
        public readonly ?string $observacoes
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id'),
            cliente_id: $request->input('cliente_id'),
            numero: $request->input('numero'),
            defeito_relatado: $request->input('defeito_relatado'),
            valor_total: (float) $request->input('valor_total', 0),
            status: OrcamentoStatus::fromString($request->input('status', 'pendente')),
            data_criacao: $request->input('data_criacao'),
            data_validade: $request->input('data_validade'),
            observacoes: $request->input('observacoes')
        );
    }

    public static function fromModel($orcamento): self
    {
        return new self(
            id: $orcamento->id,
            cliente_id: $orcamento->cliente_id,
            numero: $orcamento->numero,
            defeito_relatado: $orcamento->defeito_relatado,
            valor_total: $orcamento->valor_total,
            status: OrcamentoStatus::fromString($orcamento->status),
            data_criacao: $orcamento->data_criacao?->format('Y-m-d'),
            data_validade: $orcamento->data_validade?->format('Y-m-d'),
            observacoes: $orcamento->observacoes
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'cliente_id' => $this->cliente_id,
            'numero' => $this->numero,
            'defeito_relatado' => $this->defeito_relatado,
            'valor_total' => $this->valor_total,
            'status' => $this->status->value,
            'data_criacao' => $this->data_criacao,
            'data_validade' => $this->data_validade,
            'observacoes' => $this->observacoes,
        ];
    }

    public function toResponseArray(): array
    {
        return array_merge($this->toArray(), [
            'status_label' => $this->status->label(),
            'status_color' => $this->status->color(),
        ]);
    }
}

<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class OrdemServicoDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $numero,
        public readonly int $cliente_id,
        public readonly ?int $tecnico_id,
        public readonly string $equipamento,
        public readonly string $marca,
        public readonly string $modelo,
        public readonly ?string $numero_serie,
        public readonly string $defeito_relatado,
        public readonly ?string $defeito_encontrado,
        public readonly ?string $solucao_aplicada,
        public readonly ?string $pecas_utilizadas,
        public readonly float $valor_mao_obra,
        public readonly float $valor_pecas,
        public readonly float $valor_total,
        public readonly string $status,
        public readonly ?string $data_entrada,
        public readonly ?string $data_saida,
        public readonly ?int $garantia_dias,
        public readonly ?string $observacoes
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id'),
            numero: $request->input('numero'),
            cliente_id: $request->input('cliente_id'),
            tecnico_id: $request->input('tecnico_id'),
            equipamento: $request->input('equipamento'),
            marca: $request->input('marca'),
            modelo: $request->input('modelo'),
            numero_serie: $request->input('numero_serie'),
            defeito_relatado: $request->input('defeito_relatado'),
            defeito_encontrado: $request->input('defeito_encontrado'),
            solucao_aplicada: $request->input('solucao_aplicada'),
            pecas_utilizadas: $request->input('pecas_utilizadas'),
            valor_mao_obra: (float) $request->input('valor_mao_obra', 0),
            valor_pecas: (float) $request->input('valor_pecas', 0),
            valor_total: (float) $request->input('valor_total', 0),
            status: $request->input('status', 'pendente'),
            data_entrada: $request->input('data_entrada'),
            data_saida: $request->input('data_saida'),
            garantia_dias: $request->input('garantia_dias'),
            observacoes: $request->input('observacoes')
        );
    }

    public static function fromModel($ordemServico): self
    {
        return new self(
            id: $ordemServico->id,
            numero: $ordemServico->numero,
            cliente_id: $ordemServico->cliente_id,
            tecnico_id: $ordemServico->tecnico_id,
            equipamento: $ordemServico->equipamento,
            marca: $ordemServico->marca,
            modelo: $ordemServico->modelo,
            numero_serie: $ordemServico->numero_serie,
            defeito_relatado: $ordemServico->defeito_relatado,
            defeito_encontrado: $ordemServico->defeito_encontrado,
            solucao_aplicada: $ordemServico->solucao_aplicada,
            pecas_utilizadas: $ordemServico->pecas_utilizadas,
            valor_mao_obra: $ordemServico->valor_mao_obra,
            valor_pecas: $ordemServico->valor_pecas,
            valor_total: $ordemServico->valor_total,
            status: $ordemServico->status,
            data_entrada: $ordemServico->data_entrada?->format('Y-m-d'),
            data_saida: $ordemServico->data_saida?->format('Y-m-d'),
            garantia_dias: $ordemServico->garantia_dias,
            observacoes: $ordemServico->observacoes
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'numero' => $this->numero,
            'cliente_id' => $this->cliente_id,
            'tecnico_id' => $this->tecnico_id,
            'equipamento' => $this->equipamento,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'numero_serie' => $this->numero_serie,
            'defeito_relatado' => $this->defeito_relatado,
            'defeito_encontrado' => $this->defeito_encontrado,
            'solucao_aplicada' => $this->solucao_aplicada,
            'pecas_utilizadas' => $this->pecas_utilizadas,
            'valor_mao_obra' => $this->valor_mao_obra,
            'valor_pecas' => $this->valor_pecas,
            'valor_total' => $this->valor_total,
            'status' => $this->status,
            'data_entrada' => $this->data_entrada,
            'data_saida' => $this->data_saida,
            'garantia_dias' => $this->garantia_dias,
            'observacoes' => $this->observacoes,
        ];
    }
}

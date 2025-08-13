<?php

namespace App\Http\Controllers\Proprietario;

use App\Http\Controllers\Controller;
use App\Services\Proprietario\OrdemServicoService;
use App\DTOs\OrdemServicoDTO;
use App\Http\Requests\OrdemServicoRequest;
use App\Models\OrdemServico;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdemServicoController extends Controller
{
    public function __construct(private OrdemServicoService $service) {}

    public function index()
    {
        return response()->json($this->service->listar());
    }

    public function store(OrdemServicoRequest $request)
    {
        $dto = OrdemServicoDTO::fromRequest($request);
        $ordem = $this->service->criar($dto);
        return response()->json($ordem, Response::HTTP_CREATED);
    }

    public function show(OrdemServico $ordemServico)
    {
        return response()->json($this->service->buscarPorId($ordemServico->id));
    }

    public function update(OrdemServicoRequest $request, OrdemServico $ordemServico)
    {
        $dto = OrdemServicoDTO::fromRequest($request);
        $ordem = $this->service->atualizar($ordemServico, $dto);
        return response()->json($ordem);
    }

    public function destroy(OrdemServico $ordemServico)
    {
        $this->service->excluir($ordemServico);
        return response()->noContent();
    }

    public function imprimir(OrdemServico $ordemServico)
    {
        $ordem = $ordemServico->load(['cliente', 'tecnico']);

        $pdf = Pdf::loadView('pdfs.ordem-servico', [
            'ordem' => $ordem,
            'empresa' => [
                'nome' => 'Eletrônica Oriental',
                'endereco' => 'Rua das Flores, 123 - Centro',
                'telefone' => '(11) 99999-9999',
                'email' => 'contato@eletronicaoriental.com',
                'cnpj' => '12.345.678/0001-90'
            ]
        ]);

        return $pdf->stream("ordem-servico-{$ordemServico->numero}.pdf");
    }

    public function preview()
    {
        $request = request();

        // Buscar cliente se fornecido
        $cliente = null;
        if ($request->cliente_id) {
            $cliente = \App\Models\Cliente::find($request->cliente_id);
        }

        // Criar dados temporários para preview
        $ordemTemp = (object) [
            'numero' => $request->numero ?? 'OS-PREVIEW-001',
            'data_entrada' => now()->format('Y-m-d'),
            'data_saida' => null, // Adicionando propriedade que estava faltando
            'status' => 'pendente',
            'equipamento' => $request->equipamento ?? 'Equipamento Exemplo',
            'marca' => $request->marca ?? 'Marca Exemplo',
            'modelo' => $request->modelo ?? 'Modelo Exemplo',
            'numero_serie' => $request->numero_serie ?? null,
            'defeito_relatado' => $request->defeito_relatado ?? 'Defeito exemplo',
            'defeito_encontrado' => null,
            'solucao_aplicada' => null,
            'pecas_utilizadas' => null,
            'valor_mao_obra' => (float) ($request->valor_mao_obra ?? 0),
            'valor_pecas' => (float) ($request->valor_pecas ?? 0),
            'valor_total' => (float) ($request->valor_total ?? 0),
            'garantia_dias' => (int) ($request->garantia_dias ?? 90),
            'observacoes' => $request->observacoes ?? null,
            'cliente' => $cliente ?? (object) [
                'nome' => 'Cliente Exemplo',
                'telefone' => '(11) 99999-9999',
                'email' => 'cliente@exemplo.com',
                'endereco' => 'Rua Exemplo, 123',
                'cidade' => 'São Paulo',
                'estado' => 'SP'
            ],
            'tecnico' => null
        ];

        $pdf = Pdf::loadView('pdfs.ordem-servico', [
            'ordem' => $ordemTemp,
            'empresa' => [
                'nome' => 'Eletrônica Oriental',
                'endereco' => 'Rua das Flores, 123 - Centro',
                'telefone' => '(11) 99999-9999',
                'email' => 'contato@eletronicaoriental.com',
                'cnpj' => '12.345.678/0001-90'
            ]
        ]);

        return $pdf->stream("ordem-servico-preview.pdf");
    }
}

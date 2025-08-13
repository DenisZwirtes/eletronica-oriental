<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem de Serviço - {{ $ordem->numero }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .empresa-nome {
            font-size: 24px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 5px;
        }

        .empresa-info {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
        }

        .documento-titulo {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            color: #333;
        }

        .info-section {
            margin-bottom: 25px;
        }

        .info-title {
            font-weight: bold;
            color: #4f46e5;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 30%;
            padding: 5px 10px 5px 0;
            color: #555;
        }

        .info-value {
            display: table-cell;
            padding: 5px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .equipamento-section {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #4f46e5;
        }

        .defeito-section {
            background-color: #fef3c7;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #f59e0b;
        }

        .valores-section {
            background-color: #ecfdf5;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #10b981;
        }

        .valor-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .valor-total {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #10b981;
            padding-top: 8px;
            margin-top: 8px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }

        .assinaturas {
            display: table;
            width: 100%;
            margin-top: 30px;
        }

        .assinatura-col {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 20px;
        }

        .linha-assinatura {
            border-top: 1px solid #333;
            margin-top: 50px;
            padding-top: 5px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="header">
        <div class="empresa-nome">{{ $empresa['nome'] }}</div>
        <div class="empresa-info">{{ $empresa['endereco'] }}</div>
        <div class="empresa-info">Tel: {{ $empresa['telefone'] }} | Email: {{ $empresa['email'] }}</div>
        <div class="empresa-info">CNPJ: {{ $empresa['cnpj'] }}</div>
    </div>

    <!-- Título do Documento -->
    <div class="documento-titulo">ORDEM DE SERVIÇO</div>

    <!-- Informações da Ordem -->
    <div class="info-section">
        <div class="info-title">INFORMAÇÕES DA ORDEM</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Número da Ordem:</div>
                <div class="info-value">{{ $ordem->numero }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Data de Entrada:</div>
                <div class="info-value">{{ $ordem->data_entrada ? \Carbon\Carbon::parse($ordem->data_entrada)->format('d/m/Y') : 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">{{ ucfirst($ordem->status) }}</div>
            </div>
            @if($ordem->data_saida)
            <div class="info-row">
                <div class="info-label">Data de Saída:</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($ordem->data_saida)->format('d/m/Y') }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Informações do Cliente -->
    <div class="info-section">
        <div class="info-title">INFORMAÇÕES DO CLIENTE</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nome:</div>
                <div class="info-value">{{ $ordem->cliente->nome }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Telefone:</div>
                <div class="info-value">{{ $ordem->cliente->telefone }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $ordem->cliente->email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Endereço:</div>
                <div class="info-value">{{ $ordem->cliente->endereco }}, {{ $ordem->cliente->cidade }}/{{ $ordem->cliente->estado }}</div>
            </div>
        </div>
    </div>

    <!-- Informações do Equipamento -->
    <div class="equipamento-section">
        <div class="info-title">EQUIPAMENTO</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Tipo:</div>
                <div class="info-value">{{ $ordem->equipamento }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Marca:</div>
                <div class="info-value">{{ $ordem->marca }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Modelo:</div>
                <div class="info-value">{{ $ordem->modelo }}</div>
            </div>
            @if($ordem->numero_serie)
            <div class="info-row">
                <div class="info-label">Número de Série:</div>
                <div class="info-value">{{ $ordem->numero_serie }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Defeito Relatado -->
    <div class="defeito-section">
        <div class="info-title">DEFEITO RELATADO</div>
        <div style="padding: 10px 0;">
            {{ $ordem->defeito_relatado }}
        </div>

        @if($ordem->defeito_encontrado)
        <div class="info-title" style="margin-top: 15px;">DEFEITO ENCONTRADO</div>
        <div style="padding: 10px 0;">
            {{ $ordem->defeito_encontrado }}
        </div>
        @endif

        @if($ordem->solucao_aplicada)
        <div class="info-title" style="margin-top: 15px;">SOLUÇÃO APLICADA</div>
        <div style="padding: 10px 0;">
            {{ $ordem->solucao_aplicada }}
        </div>
        @endif

        @if($ordem->pecas_utilizadas)
        <div class="info-title" style="margin-top: 15px;">PEÇAS UTILIZADAS</div>
        <div style="padding: 10px 0;">
            {{ $ordem->pecas_utilizadas }}
        </div>
        @endif
    </div>

    <!-- Valores -->
    <div class="valores-section">
        <div class="info-title">VALORES</div>
        <div class="valor-item">
            <span>Mão de Obra:</span>
            <span>R$ {{ number_format($ordem->valor_mao_obra, 2, ',', '.') }}</span>
        </div>
        <div class="valor-item">
            <span>Peças:</span>
            <span>R$ {{ number_format($ordem->valor_pecas, 2, ',', '.') }}</span>
        </div>
        <div class="valor-item valor-total">
            <span>TOTAL:</span>
            <span>R$ {{ number_format($ordem->valor_total, 2, ',', '.') }}</span>
        </div>
    </div>

    <!-- Garantia -->
    @if($ordem->garantia_dias)
    <div class="info-section">
        <div class="info-title">GARANTIA</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Período de Garantia:</div>
                <div class="info-value">{{ $ordem->garantia_dias }} dias</div>
            </div>
        </div>
    </div>
    @endif

    <!-- Observações -->
    @if($ordem->observacoes)
    <div class="info-section">
        <div class="info-title">OBSERVAÇÕES</div>
        <div style="padding: 10px 0; background-color: #f8fafc; border-radius: 5px; padding: 15px;">
            {{ $ordem->observacoes }}
        </div>
    </div>
    @endif

    <!-- Assinaturas -->
    <div class="assinaturas">
        <div class="assinatura-col">
            <div class="linha-assinatura">Assinatura do Cliente</div>
        </div>
        <div class="assinatura-col">
            <div class="linha-assinatura">Assinatura do Técnico</div>
        </div>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        <p>Este documento é uma ordem de serviço oficial da {{ $empresa['nome'] }}.</p>
        <p>Para dúvidas, entre em contato: {{ $empresa['telefone'] }} | {{ $empresa['email'] }}</p>
        <p>Documento gerado em {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>

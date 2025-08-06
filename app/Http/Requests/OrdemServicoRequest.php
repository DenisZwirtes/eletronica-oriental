<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\UserRole;
use App\Enums\OrdemServicoStatus;
use Illuminate\Support\Facades\Auth;

class OrdemServicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()?->hasRole(UserRole::PROPRIETARIO);
    }

    public function rules(): array
    {
        $ordemId = optional(request()->route('ordem_servico'))->id;

        return [
            'numero' => 'required|string|max:50|unique:ordens_servico,numero,' . $ordemId,
            'cliente_id' => 'required|exists:clientes,id',
            'tecnico_id' => 'nullable|exists:users,id',
            'equipamento' => 'required|string|max:255',
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'defeito_relatado' => 'required|string|max:1000',
            'defeito_encontrado' => 'nullable|string|max:1000',
            'solucao_aplicada' => 'nullable|string|max:1000',
            'pecas_utilizadas' => 'nullable|string|max:1000',
            'valor_mao_obra' => 'required|numeric|min:0',
            'valor_pecas' => 'required|numeric|min:0',
            'valor_total' => 'required|numeric|min:0',
            'status' => 'required|string|in:' . implode(',', array_column(OrdemServicoStatus::cases(), 'value')),
            'data_entrada' => 'nullable|date',
            'data_saida' => 'nullable|date|after_or_equal:data_entrada',
            'garantia_dias' => 'nullable|integer|min:0',
            'observacoes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'numero.required' => 'O número da ordem de serviço é obrigatório.',
            'numero.unique' => 'Este número de ordem de serviço já existe.',
            'cliente_id.required' => 'O cliente é obrigatório.',
            'cliente_id.exists' => 'O cliente selecionado não existe.',
            'tecnico_id.exists' => 'O técnico selecionado não existe.',
            'equipamento.required' => 'O equipamento é obrigatório.',
            'marca.required' => 'A marca é obrigatória.',
            'modelo.required' => 'O modelo é obrigatório.',
            'defeito_relatado.required' => 'O defeito relatado é obrigatório.',
            'valor_mao_obra.required' => 'O valor da mão de obra é obrigatório.',
            'valor_mao_obra.numeric' => 'O valor da mão de obra deve ser um número.',
            'valor_mao_obra.min' => 'O valor da mão de obra deve ser maior ou igual a zero.',
            'valor_pecas.required' => 'O valor das peças é obrigatório.',
            'valor_pecas.numeric' => 'O valor das peças deve ser um número.',
            'valor_pecas.min' => 'O valor das peças deve ser maior ou igual a zero.',
            'valor_total.required' => 'O valor total é obrigatório.',
            'valor_total.numeric' => 'O valor total deve ser um número.',
            'valor_total.min' => 'O valor total deve ser maior ou igual a zero.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status selecionado é inválido.',
            'data_saida.after_or_equal' => 'A data de saída deve ser igual ou posterior à data de entrada.',
            'garantia_dias.integer' => 'Os dias de garantia devem ser um número inteiro.',
            'garantia_dias.min' => 'Os dias de garantia devem ser maiores ou iguais a zero.',
        ];
    }

    public function attributes(): array
    {
        return [
            'numero' => 'número da ordem de serviço',
            'cliente_id' => 'cliente',
            'tecnico_id' => 'técnico',
            'equipamento' => 'equipamento',
            'marca' => 'marca',
            'modelo' => 'modelo',
            'numero_serie' => 'número de série',
            'defeito_relatado' => 'defeito relatado',
            'defeito_encontrado' => 'defeito encontrado',
            'solucao_aplicada' => 'solução aplicada',
            'pecas_utilizadas' => 'peças utilizadas',
            'valor_mao_obra' => 'valor da mão de obra',
            'valor_pecas' => 'valor das peças',
            'valor_total' => 'valor total',
            'status' => 'status',
            'data_entrada' => 'data de entrada',
            'data_saida' => 'data de saída',
            'garantia_dias' => 'dias de garantia',
            'observacoes' => 'observações',
        ];
    }
}

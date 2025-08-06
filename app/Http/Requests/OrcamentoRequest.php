<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\UserRole;
use App\Enums\OrcamentoStatus;
use Illuminate\Support\Facades\Auth;

class OrcamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()?->hasRole(UserRole::PROPRIETARIO);
    }

    public function rules(): array
    {
        $orcamentoId = optional(request()->route('orcamento'))->id;

        return [
            'cliente_id' => 'required|exists:clientes,id',
            'numero' => 'required|string|max:50|unique:orcamentos,numero,' . $orcamentoId,
            'descricao' => 'required|string|max:1000',
            'valor_total' => 'required|numeric|min:0',
            'status' => 'required|string|in:' . implode(',', array_column(OrcamentoStatus::cases(), 'value')),
            'data_criacao' => 'nullable|date',
            'data_validade' => 'nullable|date|after_or_equal:data_criacao',
            'observacoes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'cliente_id.required' => 'O cliente é obrigatório.',
            'cliente_id.exists' => 'O cliente selecionado não existe.',
            'numero.required' => 'O número do orçamento é obrigatório.',
            'numero.unique' => 'Este número de orçamento já existe.',
            'descricao.required' => 'A descrição é obrigatória.',
            'valor_total.required' => 'O valor total é obrigatório.',
            'valor_total.numeric' => 'O valor total deve ser um número.',
            'valor_total.min' => 'O valor total deve ser maior ou igual a zero.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status selecionado é inválido.',
            'data_validade.after_or_equal' => 'A data de validade deve ser igual ou posterior à data de criação.',
            'observacoes.max' => 'As observações não podem ter mais de 1000 caracteres.',
        ];
    }

    public function attributes(): array
    {
        return [
            'cliente_id' => 'cliente',
            'numero' => 'número do orçamento',
            'descricao' => 'descrição',
            'valor_total' => 'valor total',
            'status' => 'status',
            'data_criacao' => 'data de criação',
            'data_validade' => 'data de validade',
            'observacoes' => 'observações',
        ];
    }
}

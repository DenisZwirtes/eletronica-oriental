<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;

class ClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()?->hasRole(UserRole::PROPRIETARIO);
    }

    public function rules(): array
    {
        $clienteId = optional(request()->route('cliente'))->id;

        return [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clientes,email,' . $clienteId,
            'telefone' => 'required|string|max:20',
            'endereco' => 'required|string|max:500',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'cep' => 'required|string|max:10',
            'cpf_cnpj' => 'nullable|string|max:18|unique:clientes,cpf_cnpj,' . $clienteId,
            'observacoes' => 'nullable|string|max:1000',
            'ativo' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do cliente é obrigatório.',
            'nome.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Digite um email válido.',
            'email.unique' => 'Este email já está cadastrado.',
            'telefone.required' => 'O telefone é obrigatório.',
            'endereco.required' => 'O endereço é obrigatório.',
            'cidade.required' => 'A cidade é obrigatória.',
            'estado.required' => 'O estado é obrigatório.',
            'estado.size' => 'O estado deve ter 2 caracteres.',
            'cep.required' => 'O CEP é obrigatório.',
            'cpf_cnpj.unique' => 'Este CPF/CNPJ já está cadastrado.',
            'observacoes.max' => 'As observações não podem ter mais de 1000 caracteres.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nome' => 'nome do cliente',
            'email' => 'email',
            'telefone' => 'telefone',
            'endereco' => 'endereço',
            'cidade' => 'cidade',
            'estado' => 'estado',
            'cep' => 'CEP',
            'cpf_cnpj' => 'CPF/CNPJ',
            'observacoes' => 'observações',
            'ativo' => 'status ativo',
        ];
    }
}

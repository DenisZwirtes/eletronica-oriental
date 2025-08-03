<?php

namespace App\DTOs;

class ClienteDTO
{
    public function __construct(
        public string $nome,
        public string $email,
        public string $telefone,
        public string $endereco,
        public ?string $cpf_cnpj = null,
        public ?string $observacoes = null,
        public bool $ativo = true
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
            nome: $validated['nome'],
            email: $validated['email'],
            telefone: $validated['telefone'],
            endereco: $validated['endereco'],
            cpf_cnpj: $validated['cpf_cnpj'] ?? null,
            observacoes: $validated['observacoes'] ?? null,
            ativo: $validated['ativo'] ?? true
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
            'nome' => $this->nome,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'endereco' => $this->endereco,
            'cpf_cnpj' => $this->cpf_cnpj,
            'observacoes' => $this->observacoes,
            'ativo' => $this->ativo,
        ];
    }

    /**
     * Regras de validação para criação de cliente.
     *
     * @return array
     */
    public static function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string|max:20',
            'endereco' => 'required|string|max:500',
            'cpf_cnpj' => 'nullable|string|max:18',
            'observacoes' => 'nullable|string|max:1000',
            'ativo' => 'boolean',
        ];
    }

    /**
     * Regras de validação para atualização de cliente.
     *
     * @param int $clienteId
     * @return array
     */
    public static function updateRules(int $clienteId): array
    {
        return [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clientes,email,' . $clienteId,
            'telefone' => 'required|string|max:20',
            'endereco' => 'required|string|max:500',
            'cpf_cnpj' => 'nullable|string|max:18|unique:clientes,cpf_cnpj,' . $clienteId,
            'observacoes' => 'nullable|string|max:1000',
            'ativo' => 'boolean',
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
            'nome.required' => 'O nome do cliente é obrigatório.',
            'nome.max' => 'O nome do cliente não pode ter mais de 255 caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ter um formato válido.',
            'email.max' => 'O email não pode ter mais de 255 caracteres.',
            'email.unique' => 'Este email já está sendo utilizado.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.max' => 'O telefone não pode ter mais de 20 caracteres.',
            'endereco.required' => 'O endereço é obrigatório.',
            'endereco.max' => 'O endereço não pode ter mais de 500 caracteres.',
            'cpf_cnpj.max' => 'O CPF/CNPJ não pode ter mais de 18 caracteres.',
            'cpf_cnpj.unique' => 'Este CPF/CNPJ já está sendo utilizado.',
            'observacoes.max' => 'As observações não podem ter mais de 1000 caracteres.',
            'ativo.boolean' => 'O status ativo deve ser verdadeiro ou falso.',
        ];
    }
}

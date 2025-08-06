<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class ClienteDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $nome,
        public readonly string $email,
        public readonly string $telefone,
        public readonly string $endereco,
        public readonly string $cidade,
        public readonly string $estado,
        public readonly string $cep,
        public readonly ?string $cpf_cnpj,
        public readonly ?string $observacoes,
        public readonly bool $ativo = true
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id'),
            nome: $request->input('nome'),
            email: $request->input('email'),
            telefone: $request->input('telefone'),
            endereco: $request->input('endereco'),
            cidade: $request->input('cidade'),
            estado: $request->input('estado'),
            cep: $request->input('cep'),
            cpf_cnpj: $request->input('cpf_cnpj'),
            observacoes: $request->input('observacoes'),
            ativo: $request->boolean('ativo', true)
        );
    }

    public static function fromModel($cliente): self
    {
        return new self(
            id: $cliente->id,
            nome: $cliente->nome,
            email: $cliente->email,
            telefone: $cliente->telefone,
            endereco: $cliente->endereco,
            cidade: $cliente->cidade,
            estado: $cliente->estado,
            cep: $cliente->cep,
            cpf_cnpj: $cliente->cpf_cnpj,
            observacoes: $cliente->observacoes,
            ativo: $cliente->ativo
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'endereco' => $this->endereco,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'cep' => $this->cep,
            'cpf_cnpj' => $this->cpf_cnpj,
            'observacoes' => $this->observacoes,
            'ativo' => $this->ativo,
        ];
    }
}

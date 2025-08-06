<?php

use App\DTOs\ClienteDTO;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->clienteData = [
        'nome' => 'João Silva',
        'email' => 'joao@exemplo.com',
        'telefone' => '(11) 99999-9999',
        'endereco' => 'Rua das Flores, 123',
        'cidade' => 'São Paulo',
        'estado' => 'SP',
        'cep' => '01234-567',
        'cpf_cnpj' => '123.456.789-00',
        'observacoes' => 'Cliente VIP',
        'ativo' => true,
    ];
});

test('deve criar DTO a partir de request', function () {
    $request = Request::create('/', 'POST', $this->clienteData);

    $dto = ClienteDTO::fromRequest($request);

    expect($dto->nome)->toBe('João Silva')
        ->and($dto->email)->toBe('joao@exemplo.com')
        ->and($dto->telefone)->toBe('(11) 99999-9999')
        ->and($dto->endereco)->toBe('Rua das Flores, 123')
        ->and($dto->cidade)->toBe('São Paulo')
        ->and($dto->estado)->toBe('SP')
        ->and($dto->cep)->toBe('01234-567')
        ->and($dto->cpf_cnpj)->toBe('123.456.789-00')
        ->and($dto->observacoes)->toBe('Cliente VIP')
        ->and($dto->ativo)->toBeTrue();
});

test('deve criar DTO a partir de modelo', function () {
    $cliente = Cliente::factory()->create($this->clienteData);

    $dto = ClienteDTO::fromModel($cliente);

    expect($dto->nome)->toBe('João Silva')
        ->and($dto->email)->toBe('joao@exemplo.com')
        ->and($dto->telefone)->toBe('(11) 99999-9999')
        ->and($dto->endereco)->toBe('Rua das Flores, 123')
        ->and($dto->cidade)->toBe('São Paulo')
        ->and($dto->estado)->toBe('SP')
        ->and($dto->cep)->toBe('01234-567')
        ->and($dto->cpf_cnpj)->toBe('123.456.789-00')
        ->and($dto->observacoes)->toBe('Cliente VIP')
        ->and($dto->ativo)->toBeTrue();
});

test('deve converter DTO para array', function () {
    $dto = new ClienteDTO(
        id: 1,
        nome: 'João Silva',
        email: 'joao@exemplo.com',
        telefone: '(11) 99999-9999',
        endereco: 'Rua das Flores, 123',
        cidade: 'São Paulo',
        estado: 'SP',
        cep: '01234-567',
        cpf_cnpj: '123.456.789-00',
        observacoes: 'Cliente VIP',
        ativo: true
    );

    $array = $dto->toArray();

    expect($array)->toBe([
        'id' => 1,
        'nome' => 'João Silva',
        'email' => 'joao@exemplo.com',
        'telefone' => '(11) 99999-9999',
        'endereco' => 'Rua das Flores, 123',
        'cidade' => 'São Paulo',
        'estado' => 'SP',
        'cep' => '01234-567',
        'cpf_cnpj' => '123.456.789-00',
        'observacoes' => 'Cliente VIP',
        'ativo' => true,
    ]);
});

test('deve definir valores padrão corretamente', function () {
    $request = Request::create('/', 'POST', [
        'nome' => 'João Silva',
        'email' => 'joao@exemplo.com',
        'telefone' => '(11) 99999-9999',
        'endereco' => 'Rua das Flores, 123',
        'cidade' => 'São Paulo',
        'estado' => 'SP',
        'cep' => '01234-567',
    ]);

    $dto = ClienteDTO::fromRequest($request);

    expect($dto->ativo)->toBeTrue()
        ->and($dto->cpf_cnpj)->toBeNull()
        ->and($dto->observacoes)->toBeNull();
});

<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = [
            [
                'nome' => 'João Silva',
                'email' => 'joao.silva@email.com',
                'telefone' => '(11) 99999-1111',
                'cpf_cnpj' => '123.456.789-00',
                'endereco' => 'Rua das Flores, 123',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01234-567',
                'observacoes' => 'Cliente frequente',
                'ativo' => true,
            ],
            [
                'nome' => 'Maria Santos',
                'email' => 'maria.santos@email.com',
                'telefone' => '(11) 99999-2222',
                'cpf_cnpj' => '987.654.321-00',
                'endereco' => 'Av. Paulista, 456',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01310-100',
                'observacoes' => 'Prefere atendimento pela manhã',
                'ativo' => true,
            ],
            [
                'nome' => 'Pedro Oliveira',
                'email' => 'pedro.oliveira@email.com',
                'telefone' => '(11) 99999-3333',
                'cpf_cnpj' => '111.222.333-44',
                'endereco' => 'Rua Augusta, 789',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01212-000',
                'observacoes' => 'Cliente novo',
                'ativo' => true,
            ],
            [
                'nome' => 'Ana Costa',
                'email' => 'ana.costa@email.com',
                'telefone' => '(11) 99999-4444',
                'cpf_cnpj' => '555.666.777-88',
                'endereco' => 'Rua 13 de Maio, 321',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01327-000',
                'observacoes' => 'Cliente desde 2020',
                'ativo' => true,
            ],
            [
                'nome' => 'Carlos Ferreira',
                'email' => 'carlos.ferreira@email.com',
                'telefone' => '(11) 99999-5555',
                'cpf_cnpj' => '999.888.777-66',
                'endereco' => 'Rua da Consolação, 654',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01302-000',
                'observacoes' => 'Cliente corporativo',
                'ativo' => true,
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }

        $this->command->info('Clientes de exemplo criados com sucesso!');
    }
}

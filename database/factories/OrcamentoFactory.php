<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\OrcamentoStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orcamento>
 */
class OrcamentoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cliente_id' => \App\Models\Cliente::factory(),
            'numero' => fake()->unique()->numerify('ORC-#####'),
            'atendente_id' => null,
            'equipamento' => fake()->word(),
            'marca' => fake()->company(),
            'modelo' => fake()->bothify('Modelo-##??'),
            'numero_serie' => fake()->optional()->bothify('SN-#####'),
            'defeito_relatado' => fake()->sentence(8),
            'diagnostico_preliminar' => fake()->optional()->sentence(6),
            'solucao_proposta' => fake()->optional()->sentence(6),
            'pecas_necessarias' => fake()->optional()->sentence(4),
            'valor_mao_obra' => fake()->randomFloat(2, 30, 1000),
            'valor_pecas' => fake()->randomFloat(2, 10, 2000),
            'valor_total' => fake()->randomFloat(2, 50, 5000),
            'validade_dias' => fake()->numberBetween(30, 365),
            'status' => fake()->randomElement(array_column(OrcamentoStatus::cases(), 'value')),
            'data_criacao' => fake()->date(),
            'data_validade' => fake()->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'observacoes' => fake()->optional()->sentence(),
        ];
    }
}

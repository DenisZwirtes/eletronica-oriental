<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\OrdemServicoStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrdemServico>
 */
class OrdemServicoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'numero' => fake()->unique()->numerify('OS-#####'),
            'cliente_id' => \App\Models\Cliente::factory(),
            'tecnico_id' => null, // Pode ser preenchido em testes específicos
            'equipamento' => fake()->word(),
            'marca' => fake()->company(),
            'modelo' => fake()->bothify('Modelo-##??'),
            'numero_serie' => fake()->optional()->bothify('SN-#####'),
            'defeito_relatado' => fake()->sentence(6),
            'defeito_encontrado' => fake()->optional()->sentence(6),
            'solucao_aplicada' => fake()->optional()->sentence(6),
            'pecas_utilizadas' => fake()->optional()->sentence(4),
            'valor_mao_obra' => fake()->randomFloat(2, 30, 1000),
            'valor_pecas' => fake()->randomFloat(2, 10, 2000),
            'valor_total' => function (array $attrs) {
                return ($attrs['valor_mao_obra'] ?? 0) + ($attrs['valor_pecas'] ?? 0);
            },
            'status' => fake()->randomElement(array_column(OrdemServicoStatus::cases(), 'value')),
            'data_entrada' => fake()->date(),
            'data_saida' => fake()->optional()->date(),
            'garantia_dias' => fake()->numberBetween(30, 365),
            'observacoes' => fake()->optional()->sentence(),
        ];
    }
}

<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'email' => fake()->safeEmail(),
            'telefone' => fake()->phoneNumber(),
            'criado_em' => Carbon::now()->format('Y-m-d H:i:s'),
            'atualizado_em' => Carbon::now()->format('Y-m-d H:i:s'),
            'deletado_em' => null,
        ];
    }
}

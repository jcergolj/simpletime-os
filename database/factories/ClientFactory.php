<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Models\Client;
use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            '__create_hourly_rate' => true,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Client $client) {
            $shouldCreate = $client->__create_hourly_rate ?? true;
            unset($client->__create_hourly_rate);
            $client->setRelation('_shouldCreateRate', $shouldCreate);
        })->afterCreating(function (Client $client) {
            $shouldCreate = $client->getRelation('_shouldCreateRate');
            if ($shouldCreate && $this->faker->boolean(70)) {
                $money = Money::fromDecimal(
                    amount: $this->faker->randomFloat(2, 25, 150),
                    currency: $this->faker->randomElement([Currency::USD, Currency::EUR, Currency::GBP])
                );

                $client->hourlyRate = $money;
                $client->save();
            }
        });
    }

    public function withoutHourlyRate(): static
    {
        return $this->state(fn (array $attributes) => [
            '__create_hourly_rate' => false,
        ]);
    }
}

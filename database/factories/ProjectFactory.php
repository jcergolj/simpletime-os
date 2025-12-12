<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Models\Client;
use App\Models\Project;
use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'client_id' => Client::factory(),
            '__create_hourly_rate' => true,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Project $project) {
            $shouldCreate = $project->__create_hourly_rate ?? true;
            unset($project->__create_hourly_rate);
            $project->setRelation('_shouldCreateRate', $shouldCreate);
        })->afterCreating(function (Project $project) {
            $shouldCreate = $project->getRelation('_shouldCreateRate');
            if ($shouldCreate && $this->faker->boolean(40)) {
                $money = Money::fromDecimal(
                    amount: $this->faker->randomFloat(2, 30, 200),
                    currency: $this->faker->randomElement([Currency::USD, Currency::EUR, Currency::GBP])
                );

                $project->hourlyRate = $money;
                $project->save();
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

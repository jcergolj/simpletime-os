<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeEntry>
 */
class TimeEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween('-30 days', 'now');
        $endTime = (clone $startTime)->modify('+'.$this->faker->numberBetween(30, 480).' minutes');
        $duration = $endTime->getTimestamp() - $startTime->getTimestamp();

        return [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration' => $duration,
            'notes' => $this->faker->boolean(70) ? fake()->sentence() : null,
            'client_id' => \App\Models\Client::factory(),
            'project_id' => \App\Models\Project::factory(),
            '__create_hourly_rate' => true,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (\App\Models\TimeEntry $timeEntry) {
            $shouldCreate = $timeEntry->__create_hourly_rate ?? true;
            unset($timeEntry->__create_hourly_rate);
            $timeEntry->setRelation('_shouldCreateRate', $shouldCreate);
        })->afterCreating(function (\App\Models\TimeEntry $timeEntry) {
            $shouldCreate = $timeEntry->getRelation('_shouldCreateRate');
            if ($shouldCreate && $this->faker->boolean(20)) {
                $timeEntry->hourlyRate()->create([
                    'rate' => Money::fromDecimal(
                        amount: $this->faker->randomFloat(2, 35, 250),
                        currency: $this->faker->randomElement([Currency::USD, Currency::EUR, Currency::GBP])
                    ),
                ]);
            }
        });
    }

    public function withoutHourlyRate(): static
    {
        return $this->state(fn (array $attributes) => [
            '__create_hourly_rate' => false,
        ]);
    }

    public function ongoing(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_time' => now()->subMinutes($this->faker->numberBetween(10, 120)),
            'end_time' => null,
            'duration' => null,
        ]);
    }
}

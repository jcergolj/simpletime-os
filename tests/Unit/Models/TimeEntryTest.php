<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Enums\Currency;
use App\Models\Client;
use App\Models\HourlyRate;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use App\ValueObjects\Money;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class TimeEntryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function get_effective_hourly_rate_returns_time_entry_rate_when_set(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->withoutHourlyRate()->create();
        $project = Project::factory()->withoutHourlyRate()->create(['client_id' => $client->id]);

        $timeEntryRate = Money::fromDecimal(100.00, Currency::USD);
        $projectRate = Money::fromDecimal(75.00, Currency::USD);
        $clientRate = Money::fromDecimal(50.00, Currency::USD);
        Money::fromDecimal(25.00, Currency::USD);

        // Set rates at all levels
        $project->hourlyRate()->create(['rate' => $projectRate]);
        $client->hourlyRate()->create(['rate' => $clientRate]);
        HourlyRate::createFromDecimal(25.00, Currency::USD, $user);

        $timeEntry = TimeEntry::factory()->withoutHourlyRate()->create([
            'client_id' => $client->id,
            'project_id' => $project->id,
        ]);
        $timeEntry->hourlyRate()->create(['rate' => $timeEntryRate]);

        $timeEntry->load(['hourlyRate', 'project.hourlyRate', 'client.hourlyRate']);
        $effectiveRate = $timeEntry->getEffectiveHourlyRate();

        $this->assertInstanceOf(Money::class, $effectiveRate);
        $this->assertSame(10000, $effectiveRate->amount);
        $this->assertSame(Currency::USD, $effectiveRate->currency);
    }

    #[Test]
    public function get_effective_hourly_rate_returns_project_rate_when_time_entry_rate_not_set(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->withoutHourlyRate()->create();

        $projectRate = Money::fromDecimal(75.00, Currency::USD);
        $clientRate = Money::fromDecimal(50.00, Currency::USD);

        $project = Project::factory()->withoutHourlyRate()->create([
            'client_id' => $client->id,
        ]);
        $project->hourlyRate()->create(['rate' => $projectRate]);
        $client->hourlyRate()->create(['rate' => $clientRate]);
        HourlyRate::createFromDecimal(25.00, Currency::USD, $user);

        $timeEntry = TimeEntry::factory()->withoutHourlyRate()->create([
            'client_id' => $client->id,
            'project_id' => $project->id,
        ]);

        $timeEntry->load(['hourlyRate', 'project.hourlyRate', 'client.hourlyRate']);
        $effectiveRate = $timeEntry->getEffectiveHourlyRate();

        $this->assertInstanceOf(Money::class, $effectiveRate);
        $this->assertSame(7500, $effectiveRate->amount);
        $this->assertSame(Currency::USD, $effectiveRate->currency);
    }

    #[Test]
    public function get_effective_hourly_rate_returns_client_rate_when_time_entry_and_project_rates_not_set(): void
    {
        $user = User::factory()->create();
        $clientRate = Money::fromDecimal(50.00, Currency::USD);

        $client = Client::factory()->withoutHourlyRate()->create();
        $client->hourlyRate()->create(['rate' => $clientRate]);
        $project = Project::factory()->withoutHourlyRate()->create([
            'client_id' => $client->id,
        ]);
        HourlyRate::createFromDecimal(25.00, Currency::USD, $user);

        $timeEntry = TimeEntry::factory()->withoutHourlyRate()->create([
            'client_id' => $client->id,
            'project_id' => $project->id,
        ]);

        $timeEntry->load(['hourlyRate', 'project.hourlyRate', 'client.hourlyRate']);
        $effectiveRate = $timeEntry->getEffectiveHourlyRate();

        $this->assertInstanceOf(Money::class, $effectiveRate);
        $this->assertSame(5000, $effectiveRate->amount);
        $this->assertSame(Currency::USD, $effectiveRate->currency);
    }

    #[Test]
    public function get_effective_hourly_rate_returns_user_rate_when_time_entry_project_and_client_rates_not_set(): void
    {
        $user = User::factory()->create();
        HourlyRate::createFromDecimal(25.00, Currency::USD, $user);

        $client = Client::factory()->withoutHourlyRate()->create();
        $project = Project::factory()->withoutHourlyRate()->create([
            'client_id' => $client->id,
        ]);

        $timeEntry = TimeEntry::factory()->withoutHourlyRate()->create([
            'client_id' => $client->id,
            'project_id' => $project->id,
        ]);

        $timeEntry->load(['hourlyRate', 'project.hourlyRate', 'client.hourlyRate']);
        $effectiveRate = $timeEntry->getEffectiveHourlyRate();

        $this->assertInstanceOf(Money::class, $effectiveRate);
        $this->assertSame(2500, $effectiveRate->amount);
        $this->assertSame(Currency::USD, $effectiveRate->currency);
    }

    #[Test]
    public function get_effective_hourly_rate_returns_null_when_no_rates_set(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->withoutHourlyRate()->create();
        $project = Project::factory()->withoutHourlyRate()->create([
            'client_id' => $client->id,
        ]);

        $timeEntry = TimeEntry::factory()->withoutHourlyRate()->create([
            'client_id' => $client->id,
            'project_id' => $project->id,
        ]);

        $timeEntry->load(['hourlyRate', 'project.hourlyRate', 'client.hourlyRate']);
        $effectiveRate = $timeEntry->getEffectiveHourlyRate();

        $this->assertNull($effectiveRate);
    }

    #[Test]
    public function get_effective_hourly_rate_handles_no_user_rate(): void
    {
        $client = Client::factory()->withoutHourlyRate()->create();
        $project = Project::factory()->withoutHourlyRate()->create([
            'client_id' => $client->id,
        ]);

        $timeEntry = TimeEntry::factory()->withoutHourlyRate()->create([
            'client_id' => $client->id,
            'project_id' => $project->id,
        ]);

        $timeEntry->load(['hourlyRate', 'project.hourlyRate', 'client.hourlyRate']);
        $effectiveRate = $timeEntry->getEffectiveHourlyRate();

        $this->assertNull($effectiveRate);
    }

    #[Test]
    public function calculate_earnings_uses_effective_hourly_rate(): void
    {
        $user = User::factory()->create();
        HourlyRate::createFromDecimal(50.00, Currency::USD, $user);

        $client = Client::factory()->withoutHourlyRate()->create();
        $project = Project::factory()->withoutHourlyRate()->create([
            'client_id' => $client->id,
        ]);

        // 2 hours = 7200 seconds
        $timeEntry = TimeEntry::factory()->withoutHourlyRate()->create([
            'client_id' => $client->id,
            'project_id' => $project->id,
            'duration' => 7200,
        ]);

        $timeEntry->load(['hourlyRate', 'project.hourlyRate', 'client.hourlyRate']);
        $earnings = $timeEntry->calculateEarnings();

        $this->assertInstanceOf(Money::class, $earnings);
        // 2 hours * $50 = $100 = 10000 cents
        $this->assertSame(10000, $earnings->amount);
        $this->assertSame(Currency::USD, $earnings->currency);
    }
}

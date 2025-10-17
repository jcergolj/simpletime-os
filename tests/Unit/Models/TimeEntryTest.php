<?php

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

class TimeEntryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function time_entry_model_casts_user_id_to_integer(): void
    {
        $timeEntry = new TimeEntry;
        $casts = $timeEntry->getCasts();

        $this->assertArrayHasKey('user_id', $casts);
        $this->assertSame('integer', $casts['user_id']);
    }

    #[Test]
    public function get_effective_hourly_rate_returns_time_entry_rate_when_set(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->create(['client_id' => $client->id]);

        $timeEntryRate = Money::fromDecimal(100.00, Currency::USD);
        $projectRate = Money::fromDecimal(75.00, Currency::USD);
        $clientRate = Money::fromDecimal(50.00, Currency::USD);
        $userRate = Money::fromDecimal(25.00, Currency::USD);

        // Set rates at all levels
        $project->update(['hourly_rate' => $projectRate]);
        $client->update(['hourly_rate' => $clientRate]);
        HourlyRate::createFromDecimal(25.00, Currency::USD, $user);

        $timeEntry = TimeEntry::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'project_id' => $project->id,
            'hourly_rate' => $timeEntryRate,
        ]);

        $effectiveRate = $timeEntry->getEffectiveHourlyRate();

        $this->assertInstanceOf(Money::class, $effectiveRate);
        $this->assertEquals(10000, $effectiveRate->amount);
        $this->assertEquals(Currency::USD, $effectiveRate->currency);
    }

    #[Test]
    public function get_effective_hourly_rate_returns_project_rate_when_time_entry_rate_not_set(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        $projectRate = Money::fromDecimal(75.00, Currency::USD);
        $clientRate = Money::fromDecimal(50.00, Currency::USD);

        $project = Project::factory()->create([
            'client_id' => $client->id,
            'hourly_rate' => $projectRate,
        ]);
        $client->update(['hourly_rate' => $clientRate]);
        HourlyRate::createFromDecimal(25.00, Currency::USD, $user);

        $timeEntry = TimeEntry::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'project_id' => $project->id,
            'hourly_rate' => null,
        ]);

        $effectiveRate = $timeEntry->getEffectiveHourlyRate();

        $this->assertInstanceOf(Money::class, $effectiveRate);
        $this->assertEquals(7500, $effectiveRate->amount);
        $this->assertEquals(Currency::USD, $effectiveRate->currency);
    }

    #[Test]
    public function get_effective_hourly_rate_returns_client_rate_when_time_entry_and_project_rates_not_set(): void
    {
        $user = User::factory()->create();
        $clientRate = Money::fromDecimal(50.00, Currency::USD);

        $client = Client::factory()->create([
            'hourly_rate' => $clientRate,
        ]);
        $project = Project::factory()->create([
            'client_id' => $client->id,
            'hourly_rate' => null,
        ]);
        HourlyRate::createFromDecimal(25.00, Currency::USD, $user);

        $timeEntry = TimeEntry::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'project_id' => $project->id,
            'hourly_rate' => null,
        ]);

        $effectiveRate = $timeEntry->getEffectiveHourlyRate();

        $this->assertInstanceOf(Money::class, $effectiveRate);
        $this->assertEquals(5000, $effectiveRate->amount);
        $this->assertEquals(Currency::USD, $effectiveRate->currency);
    }

    #[Test]
    public function get_effective_hourly_rate_returns_user_rate_when_time_entry_project_and_client_rates_not_set(): void
    {
        $user = User::factory()->create();
        HourlyRate::createFromDecimal(25.00, Currency::USD, $user);

        $client = Client::factory()->create([
            'hourly_rate' => null,
        ]);
        $project = Project::factory()->create([
            'client_id' => $client->id,
            'hourly_rate' => null,
        ]);

        $timeEntry = TimeEntry::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'project_id' => $project->id,
            'hourly_rate' => null,
        ]);

        $effectiveRate = $timeEntry->getEffectiveHourlyRate();

        $this->assertInstanceOf(Money::class, $effectiveRate);
        $this->assertEquals(2500, $effectiveRate->amount);
        $this->assertEquals(Currency::USD, $effectiveRate->currency);
    }

    #[Test]
    public function get_effective_hourly_rate_returns_null_when_no_rates_set(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'hourly_rate' => null,
        ]);
        $project = Project::factory()->create([
            'client_id' => $client->id,
            'hourly_rate' => null,
        ]);

        $timeEntry = TimeEntry::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'project_id' => $project->id,
            'hourly_rate' => null,
        ]);

        $effectiveRate = $timeEntry->getEffectiveHourlyRate();

        $this->assertNull($effectiveRate);
    }

    #[Test]
    public function get_effective_hourly_rate_handles_null_user(): void
    {
        $client = Client::factory()->create([
            'hourly_rate' => null,
        ]);
        $project = Project::factory()->create([
            'client_id' => $client->id,
            'hourly_rate' => null,
        ]);

        $timeEntry = TimeEntry::factory()->create([
            'user_id' => null,
            'client_id' => $client->id,
            'project_id' => $project->id,
            'hourly_rate' => null,
        ]);

        $effectiveRate = $timeEntry->getEffectiveHourlyRate();

        $this->assertNull($effectiveRate);
    }

    #[Test]
    public function calculate_earnings_uses_effective_hourly_rate(): void
    {
        $user = User::factory()->create();
        HourlyRate::createFromDecimal(50.00, Currency::USD, $user);

        $client = Client::factory()->create(['hourly_rate' => null]);
        $project = Project::factory()->create([
            'client_id' => $client->id,
            'hourly_rate' => null,
        ]);

        // 2 hours = 7200 seconds
        $timeEntry = TimeEntry::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'project_id' => $project->id,
            'hourly_rate' => null,
            'duration' => 7200,
        ]);

        $earnings = $timeEntry->calculateEarnings();

        $this->assertInstanceOf(Money::class, $earnings);
        // 2 hours * $50 = $100 = 10000 cents
        $this->assertEquals(10000, $earnings->amount);
        $this->assertEquals(Currency::USD, $earnings->currency);
    }

    #[Test]
    public function time_entry_has_user_relationship(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->create(['client_id' => $client->id]);

        $timeEntry = TimeEntry::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'project_id' => $project->id,
        ]);

        $this->assertInstanceOf(User::class, $timeEntry->user);
        $this->assertEquals($user->id, $timeEntry->user->id);
    }
}

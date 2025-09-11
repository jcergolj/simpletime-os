<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Currency;
use App\Models\Client;
use App\Models\HourlyRate;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use App\Services\DashboardMetricsService;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class TimeEntryLazyLoadingTest extends TestCase
{
    #[Test]
    public function dashboard_loads_without_lazy_loading_violations(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create();

        HourlyRate::createFromDecimal(50.00, Currency::USD, $project);

        // Create completed time entries for this week
        TimeEntry::factory()->create([
            'client_id' => $client->id,
            'project_id' => $project->id,
            'start_time' => now()->subHours(2),
            'end_time' => now()->subHours(1),
            'duration' => 3600,
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
    }

    #[Test]
    public function weekly_metrics_can_be_calculated_without_lazy_loading_violations(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create();

        HourlyRate::createFromDecimal(50.00, Currency::USD, $project);

        // Create multiple time entries for this week
        TimeEntry::factory()->count(3)->create([
            'client_id' => $client->id,
            'project_id' => $project->id,
            'start_time' => now()->subHours(2),
            'end_time' => now()->subHours(1),
            'duration' => 3600,
        ]);

        $this->actingAs($user);

        $dashboardMetrics = app(DashboardMetricsService::class);
        $metrics = $dashboardMetrics->getWeeklyMetrics();

        $this->assertNotNull($metrics);
        $this->assertGreaterThan(0, $metrics->totalHours);
    }

    #[Test]
    public function time_entries_with_project_hourly_rate_calculate_earnings_correctly(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create();

        HourlyRate::createFromDecimal(50.00, Currency::USD, $project);

        TimeEntry::factory()->create([
            'client_id' => $client->id,
            'project_id' => $project->id,
            'start_time' => now()->subHours(2),
            'end_time' => now()->subHours(1),
            'duration' => 3600,
        ]);

        $this->actingAs($user);

        $dashboardMetrics = app(DashboardMetricsService::class);
        $metrics = $dashboardMetrics->getWeeklyMetrics();

        $this->assertNotEmpty($metrics->weeklyEarnings);
    }

    #[Test]
    public function recent_entries_load_without_lazy_loading_violations(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create();

        TimeEntry::factory()->count(5)->create([
            'client_id' => $client->id,
            'project_id' => $project->id,
            'start_time' => now()->subHours(2),
            'end_time' => now()->subHours(1),
            'duration' => 3600,
        ]);

        $this->actingAs($user);

        $dashboardMetrics = app(DashboardMetricsService::class);
        $recentEntries = $dashboardMetrics->getRecentEntries();

        $this->assertCount(5, $recentEntries);
    }

    #[Test]
    public function running_timer_loads_without_lazy_loading_violations(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create();

        TimeEntry::factory()->create([
            'client_id' => $client->id,
            'project_id' => $project->id,
            'start_time' => now()->subMinutes(30),
            'end_time' => null,
            'duration' => null,
        ]);

        $this->actingAs($user);

        $dashboardMetrics = app(DashboardMetricsService::class);
        $runningTimer = $dashboardMetrics->getRunningTimer();

        $this->assertNotNull($runningTimer);
        $this->assertNull($runningTimer->end_time);
    }

    #[Test]
    public function user_hourly_rate_is_used_as_fallback_without_lazy_loading_violations(): void
    {
        $user = User::factory()->create();
        HourlyRate::createFromDecimal(75.00, Currency::USD, $user);

        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create();

        // Create multiple time entries without project or client hourly rates
        $timeEntries = TimeEntry::factory()->count(3)->create([
            'client_id' => $client->id,
            'project_id' => $project->id,
            'start_time' => now()->subHours(2),
            'end_time' => now()->subHours(1),
            'duration' => 3600,
        ]);

        $this->actingAs($user);

        // Call getEffectiveHourlyRate() on each entry
        // This should use the cached user, not cause N+1 queries
        foreach ($timeEntries as $entry) {
            $rate = $entry->getEffectiveHourlyRate();
            $this->assertNotNull($rate);
            $this->assertEquals(7500, $rate->amount); // 75.00 in cents
            $this->assertEquals(Currency::USD, $rate->currency);
        }
    }
}

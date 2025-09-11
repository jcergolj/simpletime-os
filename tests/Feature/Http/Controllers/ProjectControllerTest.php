<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Enums\Currency;
use App\Http\Controllers\Turbo\ProjectController;
use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use App\ValueObjects\Money;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ProjectController::class)]
#[CoversMethod(ProjectController::class, 'update')]
final class ProjectControllerTest extends TestCase
{
    #[Test]
    public function auth_middleware_is_applied_for_update(): void
    {
        $project = Project::factory()->create();

        $response = $this->put(route('projects.update', $project));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function changing_hourly_rate_without_checkbox_keeps_existing_entries_unchanged(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->withoutHourlyRate()->for($client)->create();
        $project->hourlyRate = Money::fromDecimal(50, Currency::USD);
        $project->save();

        $timeEntry = TimeEntry::factory()->withoutHourlyRate()->for($client)->for($project)->create();

        $response = $this->actingAs($user)->put(route('projects.update', $project), [
            'name' => $project->name,
            'client_id' => $client->id,
            'hourly_rate_amount' => '70.00',
            'hourly_rate_currency' => 'EUR',
            // Checkbox not checked
        ]);

        $response->assertOk();

        // Project should be updated
        $this->assertEquals(7000, $project->fresh()->hourlyRate->amount);
        $this->assertEquals(Currency::EUR, $project->fresh()->hourlyRate->currency);

        // Time entry should remain NULL (not updated)
        $this->assertNull($timeEntry->fresh()->hourlyRate);
    }

    #[Test]
    public function changing_hourly_rate_with_checkbox_updates_entries_with_null_rates(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->withoutHourlyRate()->for($client)->create();
        $project->hourlyRate = Money::fromDecimal(50, Currency::USD);
        $project->save();

        $timeEntry1 = TimeEntry::factory()->withoutHourlyRate()->for($client)->for($project)->create();

        $timeEntry2 = TimeEntry::factory()->withoutHourlyRate()->for($client)->for($project)->create();

        $response = $this->actingAs($user)->put(route('projects.update', $project), [
            'name' => $project->name,
            'client_id' => $client->id,
            'hourly_rate_amount' => '70.00',
            'hourly_rate_currency' => 'EUR',
            'update_existing_entries' => '1',
        ]);

        $response->assertOk();

        // Project should be updated
        $this->assertEquals(7000, $project->fresh()->hourlyRate->amount);
        $this->assertEquals(Currency::EUR, $project->fresh()->hourlyRate->currency);

        // Time entries should be updated to the new rate
        $this->assertEquals(7000, $timeEntry1->fresh()->hourlyRate->amount);
        $this->assertEquals(Currency::EUR, $timeEntry1->fresh()->hourlyRate->currency);

        $this->assertEquals(7000, $timeEntry2->fresh()->hourlyRate->amount);
        $this->assertEquals(Currency::EUR, $timeEntry2->fresh()->hourlyRate->currency);
    }

    #[Test]
    public function changing_hourly_rate_with_checkbox_preserves_entries_with_custom_rates(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->withoutHourlyRate()->for($client)->create();
        $project->hourlyRate = Money::fromDecimal(50, Currency::USD);
        $project->save();

        $inheritedEntry = TimeEntry::factory()->withoutHourlyRate()->for($client)->for($project)->create();

        $customEntry = TimeEntry::factory()->withoutHourlyRate()->for($client)->for($project)->create();
        $customEntry->hourlyRate = Money::fromDecimal(100, Currency::GBP);
        $customEntry->save();

        $response = $this->actingAs($user)->put(route('projects.update', $project), [
            'name' => $project->name,
            'client_id' => $client->id,
            'hourly_rate_amount' => '70.00',
            'hourly_rate_currency' => 'EUR',
            'update_existing_entries' => '1',
        ]);

        $response->assertOk();

        // Inherited entry should be updated
        $this->assertEquals(7000, $inheritedEntry->fresh()->hourlyRate->amount);
        $this->assertEquals(Currency::EUR, $inheritedEntry->fresh()->hourlyRate->currency);

        // Custom entry should remain unchanged
        $this->assertEquals(10000, $customEntry->fresh()->hourlyRate->amount);
        $this->assertEquals(Currency::GBP, $customEntry->fresh()->hourlyRate->currency);
    }

    #[Test]
    public function not_changing_hourly_rate_with_checkbox_has_no_effect(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->withoutHourlyRate()->for($client)->create();
        $project->hourlyRate = Money::fromDecimal(50, Currency::USD);
        $project->save();

        $timeEntry = TimeEntry::factory()->withoutHourlyRate()->for($client)->for($project)->create();

        $response = $this->actingAs($user)->put(route('projects.update', $project), [
            'name' => $project->name,
            'client_id' => $client->id,
            'hourly_rate_amount' => '50.00', // Same as current
            'hourly_rate_currency' => 'USD', // Same as current
            'update_existing_entries' => '1', // Checkbox checked but rate unchanged
        ]);

        $response->assertOk();

        // Time entry should remain NULL (no change detected)
        $this->assertNull($timeEntry->fresh()->hourlyRate);
    }

    #[Test]
    public function changing_name_only_does_not_affect_time_entries(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->withoutHourlyRate()->for($client)->create([
            'name' => 'Original Name',
        ]);
        $project->hourlyRate = Money::fromDecimal(50, Currency::USD);
        $project->save();

        $timeEntry = TimeEntry::factory()->withoutHourlyRate()->for($client)->for($project)->create();

        $response = $this->actingAs($user)->put(route('projects.update', $project), [
            'name' => 'New Name',
            'client_id' => $client->id,
            'hourly_rate_amount' => '50.00',
            'hourly_rate_currency' => 'USD',
            'update_existing_entries' => '1',
        ]);

        $response->assertOk();

        // Project name should be updated
        $this->assertEquals('New Name', $project->fresh()->name);

        // Time entry should remain NULL (rate didn't change)
        $this->assertNull($timeEntry->fresh()->hourlyRate);
    }

    #[Test]
    public function checkbox_is_visible_when_project_has_inherited_time_entries(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->withoutHourlyRate()->for($client)->create();
        $project->hourlyRate = Money::fromDecimal(50, Currency::USD);
        $project->save();

        TimeEntry::factory()->withoutHourlyRate()->for($client)->for($project)->create();

        TimeEntry::factory()->withoutHourlyRate()->for($client)->for($project)->create();

        $response = $this->actingAs($user)->get(route('projects.edit', $project));

        $response->assertOk()
            ->assertSee('Update old time entries too?')
            ->assertSee('Applies new rate to past entries');
    }

    #[Test]
    public function checkbox_is_not_visible_when_project_has_no_inherited_time_entries(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->withoutHourlyRate()->for($client)->create();
        $project->hourlyRate = Money::fromDecimal(50, Currency::USD);
        $project->save();

        // Create time entry with custom rate (not inherited)
        $customEntry = TimeEntry::factory()->withoutHourlyRate()->for($client)->for($project)->create();
        $customEntry->hourlyRate = Money::fromDecimal(100, Currency::GBP);
        $customEntry->save();

        $response = $this->actingAs($user)->get(route('projects.edit', $project));

        $response->assertOk()
            ->assertDontSee('existing time entries too')
            ->assertDontSee('Applies new rate to past entries');
    }

    #[Test]
    public function removing_hourly_rate_with_checkbox_sets_entries_to_null(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->withoutHourlyRate()->for($client)->create();
        $project->hourlyRate = Money::fromDecimal(50, Currency::USD);
        $project->save();

        $timeEntry = TimeEntry::factory()->withoutHourlyRate()->for($client)->for($project)->create();

        $response = $this->actingAs($user)->put(route('projects.update', $project), [
            'name' => $project->name,
            'client_id' => $client->id,
            'hourly_rate_amount' => '', // Remove hourly rate
            'update_existing_entries' => '1',
        ]);

        $response->assertOk();

        // Project hourly rate should be null
        $this->assertNull($project->fresh()->hourlyRate);

        // Time entry should remain null
        $this->assertNull($timeEntry->fresh()->hourlyRate);
    }

    #[Test]
    public function adding_hourly_rate_with_checkbox_updates_inherited_entries(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->withoutHourlyRate()->for($client)->create();

        $timeEntry = TimeEntry::factory()->withoutHourlyRate()->for($client)->for($project)->create();

        $response = $this->actingAs($user)->put(route('projects.update', $project), [
            'name' => $project->name,
            'client_id' => $client->id,
            'hourly_rate_amount' => '75.00',
            'hourly_rate_currency' => 'EUR',
            'update_existing_entries' => '1',
        ]);

        $response->assertOk();

        // Project should now have a rate
        $this->assertEquals(7500, $project->fresh()->hourlyRate->amount);
        $this->assertEquals(Currency::EUR, $project->fresh()->hourlyRate->currency);

        // Time entry should be updated
        $this->assertEquals(7500, $timeEntry->fresh()->hourlyRate->amount);
        $this->assertEquals(Currency::EUR, $timeEntry->fresh()->hourlyRate->currency);
    }
}

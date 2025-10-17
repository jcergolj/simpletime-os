<?php

namespace Tests\Feature\Http\Controllers\Turbo;

use App\Enums\Currency;
use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use App\ValueObjects\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[\PHPUnit\Framework\Attributes\CoversClass(\App\Http\Controllers\Turbo\ProjectController::class)]
#[\PHPUnit\Framework\Attributes\CoversMethod(\App\Http\Controllers\Turbo\ProjectController::class, 'update')]
class ProjectControllerTest extends TestCase
{
    #[Test]
    public function auth_middleware_is_applied_for_update(): void
    {
        $project = Project::factory()->create();

        $response = $this->put(route('turbo.projects.update', $project));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function changing_hourly_rate_without_checkbox_keeps_existing_entries_unchanged(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create([
            'hourly_rate' => Money::fromDecimal(50, Currency::USD),
        ]);

        $timeEntry = TimeEntry::factory()->for($client)->for($project)->create([
            'hourly_rate' => null, // Inherits from project
        ]);

        $response = $this->actingAs($user)->put(route('turbo.projects.update', $project), [
            'name' => $project->name,
            'client_id' => $client->id,
            'hourly_rate_amount' => '70.00',
            'hourly_rate_currency' => 'EUR',
            // Checkbox not checked
        ]);

        $response->assertOk();

        // Project should be updated
        $this->assertEquals(7000, $project->fresh()->hourly_rate->amount);
        $this->assertEquals(Currency::EUR, $project->fresh()->hourly_rate->currency);

        // Time entry should remain NULL (not updated)
        $this->assertNull($timeEntry->fresh()->hourly_rate);
    }

    #[Test]
    public function changing_hourly_rate_with_checkbox_updates_entries_with_null_rates(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create([
            'hourly_rate' => Money::fromDecimal(50, Currency::USD),
        ]);

        $timeEntry1 = TimeEntry::factory()->for($client)->for($project)->create([
            'hourly_rate' => null,
        ]);

        $timeEntry2 = TimeEntry::factory()->for($client)->for($project)->create([
            'hourly_rate' => null,
        ]);

        $response = $this->actingAs($user)->put(route('turbo.projects.update', $project), [
            'name' => $project->name,
            'client_id' => $client->id,
            'hourly_rate_amount' => '70.00',
            'hourly_rate_currency' => 'EUR',
            'update_existing_entries' => '1',
        ]);

        $response->assertOk();

        // Project should be updated
        $this->assertEquals(7000, $project->fresh()->hourly_rate->amount);
        $this->assertEquals(Currency::EUR, $project->fresh()->hourly_rate->currency);

        // Time entries should be updated to the new rate
        $this->assertEquals(7000, $timeEntry1->fresh()->hourly_rate->amount);
        $this->assertEquals(Currency::EUR, $timeEntry1->fresh()->hourly_rate->currency);

        $this->assertEquals(7000, $timeEntry2->fresh()->hourly_rate->amount);
        $this->assertEquals(Currency::EUR, $timeEntry2->fresh()->hourly_rate->currency);
    }

    #[Test]
    public function changing_hourly_rate_with_checkbox_preserves_entries_with_custom_rates(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create([
            'hourly_rate' => Money::fromDecimal(50, Currency::USD),
        ]);

        $inheritedEntry = TimeEntry::factory()->for($client)->for($project)->create([
            'hourly_rate' => null, // Should be updated
        ]);

        $customEntry = TimeEntry::factory()->for($client)->for($project)->create([
            'hourly_rate' => Money::fromDecimal(100, Currency::GBP), // Should NOT be updated
        ]);

        $response = $this->actingAs($user)->put(route('turbo.projects.update', $project), [
            'name' => $project->name,
            'client_id' => $client->id,
            'hourly_rate_amount' => '70.00',
            'hourly_rate_currency' => 'EUR',
            'update_existing_entries' => '1',
        ]);

        $response->assertOk();

        // Inherited entry should be updated
        $this->assertEquals(7000, $inheritedEntry->fresh()->hourly_rate->amount);
        $this->assertEquals(Currency::EUR, $inheritedEntry->fresh()->hourly_rate->currency);

        // Custom entry should remain unchanged
        $this->assertEquals(10000, $customEntry->fresh()->hourly_rate->amount);
        $this->assertEquals(Currency::GBP, $customEntry->fresh()->hourly_rate->currency);
    }

    #[Test]
    public function not_changing_hourly_rate_with_checkbox_has_no_effect(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create([
            'hourly_rate' => Money::fromDecimal(50, Currency::USD),
        ]);

        $timeEntry = TimeEntry::factory()->for($client)->for($project)->create([
            'hourly_rate' => null,
        ]);

        $response = $this->actingAs($user)->put(route('turbo.projects.update', $project), [
            'name' => $project->name,
            'client_id' => $client->id,
            'hourly_rate_amount' => '50.00', // Same as current
            'hourly_rate_currency' => 'USD', // Same as current
            'update_existing_entries' => '1', // Checkbox checked but rate unchanged
        ]);

        $response->assertOk();

        // Time entry should remain NULL (no change detected)
        $this->assertNull($timeEntry->fresh()->hourly_rate);
    }

    #[Test]
    public function changing_name_only_does_not_affect_time_entries(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create([
            'name' => 'Original Name',
            'hourly_rate' => Money::fromDecimal(50, Currency::USD),
        ]);

        $timeEntry = TimeEntry::factory()->for($client)->for($project)->create([
            'hourly_rate' => null,
        ]);

        $response = $this->actingAs($user)->put(route('turbo.projects.update', $project), [
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
        $this->assertNull($timeEntry->fresh()->hourly_rate);
    }

    #[Test]
    public function checkbox_is_visible_when_project_has_inherited_time_entries(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create([
            'hourly_rate' => Money::fromDecimal(50, Currency::USD),
        ]);

        TimeEntry::factory()->for($client)->for($project)->create([
            'hourly_rate' => null,
        ]);

        TimeEntry::factory()->for($client)->for($project)->create([
            'hourly_rate' => null,
        ]);

        $response = $this->actingAs($user)->get(route('turbo.projects.edit', $project));

        $response->assertOk()
            ->assertSee('Adjust 2 existing time entries too')
            ->assertSee('Applies new rate to past entries');
    }

    #[Test]
    public function checkbox_is_not_visible_when_project_has_no_inherited_time_entries(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create([
            'hourly_rate' => Money::fromDecimal(50, Currency::USD),
        ]);

        // Create time entry with custom rate (not inherited)
        TimeEntry::factory()->for($client)->for($project)->create([
            'hourly_rate' => Money::fromDecimal(100, Currency::GBP),
        ]);

        $response = $this->actingAs($user)->get(route('turbo.projects.edit', $project));

        $response->assertOk()
            ->assertDontSee('existing time entries too')
            ->assertDontSee('Applies new rate to past entries');
    }

    #[Test]
    public function removing_hourly_rate_with_checkbox_sets_entries_to_null(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create([
            'hourly_rate' => Money::fromDecimal(50, Currency::USD),
        ]);

        $timeEntry = TimeEntry::factory()->for($client)->for($project)->create([
            'hourly_rate' => null,
        ]);

        $response = $this->actingAs($user)->put(route('turbo.projects.update', $project), [
            'name' => $project->name,
            'client_id' => $client->id,
            'hourly_rate_amount' => '', // Remove hourly rate
            'update_existing_entries' => '1',
        ]);

        $response->assertOk();

        // Project hourly rate should be null
        $this->assertNull($project->fresh()->hourly_rate);

        // Time entry should remain null
        $this->assertNull($timeEntry->fresh()->hourly_rate);
    }

    #[Test]
    public function adding_hourly_rate_with_checkbox_updates_inherited_entries(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $project = Project::factory()->for($client)->create([
            'hourly_rate' => null, // No rate initially
        ]);

        $timeEntry = TimeEntry::factory()->for($client)->for($project)->create([
            'hourly_rate' => null,
        ]);

        $response = $this->actingAs($user)->put(route('turbo.projects.update', $project), [
            'name' => $project->name,
            'client_id' => $client->id,
            'hourly_rate_amount' => '75.00',
            'hourly_rate_currency' => 'EUR',
            'update_existing_entries' => '1',
        ]);

        $response->assertOk();

        // Project should now have a rate
        $this->assertEquals(7500, $project->fresh()->hourly_rate->amount);
        $this->assertEquals(Currency::EUR, $project->fresh()->hourly_rate->currency);

        // Time entry should be updated
        $this->assertEquals(7500, $timeEntry->fresh()->hourly_rate->amount);
        $this->assertEquals(Currency::EUR, $timeEntry->fresh()->hourly_rate->currency);
    }
}

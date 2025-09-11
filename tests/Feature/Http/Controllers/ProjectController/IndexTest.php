<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\ProjectController;

use App\Http\Controllers\ProjectController;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ProjectController::class)]
#[CoversMethod(ProjectController::class, 'index')]
final class IndexTest extends TestCase
{
    #[Test]
    public function assert_auth_middleware_is_applied(): void
    {
        $response = $this->get(route('projects.index'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function user_can_view_projects(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['name' => 'Joe Doe']);

        Project::factory()
            ->for($client)
            ->create(['name' => 'Simple']);

        $response = $this->actingAs($user)
            ->get(route('projects.index'));

        $response->assertOk()
            ->assertSee('Simple')
            ->assertSee('Joe Doe');
    }

    #[Test]
    public function user_can_search_projects_by_name(): void
    {
        $user = User::factory()->create();

        Project::factory()->create(['name' => 'Simple']);
        Project::factory()->create(['name' => 'Jcergolj']);

        $response = $this->actingAs($user)
            ->get(route('projects.index', ['search' => 'Simple']));

        $response->assertOk()
            ->assertSee('Simple')
            ->assertDontSee('Jcergolj');
    }

    #[Test]
    public function user_can_search_projects_by_client_name(): void
    {
        $user = User::factory()->create();

        $clientJoe = Client::factory()->create(['name' => 'Joe Doe']);
        $clientJane = Client::factory()->create(['name' => 'Jane Doe']);

        Project::factory()
            ->for($clientJoe)
            ->create(['name' => 'Simple']);

        Project::factory()
            ->for($clientJane)
            ->create(['name' => 'Jcergolj']);

        $response = $this->actingAs($user)
            ->get(route('projects.index', ['search' => 'Joe']));

        $response->assertOk()
            ->assertSee('Simple')
            ->assertSee('Joe Doe')
            ->assertDontSee('Jcergolj')
            ->assertDontSee('Jane Doe');
    }

    #[Test]
    public function projects_are_paginated(): void
    {
        $user = User::factory()->create();

        Project::factory()->count(15)->create();

        $response = $this->actingAs($user)
            ->get(route('projects.index'));

        $response->assertOk()
            ->assertSee('Next');
    }

    #[Test]
    public function search_parameter_is_retained_in_pagination(): void
    {
        $user = User::factory()->create();

        Project::factory()->count(15)->create(['name' => 'Simple']);
        Project::factory()->count(5)->create(['name' => 'Jcergolj']);

        $response = $this->actingAs($user)
            ->get(route('projects.index', ['search' => 'Simple']));

        $response->assertOk();

        $this->assertStringContainsString('search=Simple', (string) $response->getContent());
    }
}

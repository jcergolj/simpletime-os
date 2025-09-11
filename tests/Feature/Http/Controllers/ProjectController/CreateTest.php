<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\ProjectController;

use App\Http\Controllers\ProjectController;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ProjectController::class)]
#[CoversMethod(ProjectController::class, 'create')]
final class CreateTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function assert_auth_middleware_is_applied(): void
    {
        $response = $this->get(route('turbo.projects.create'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function user_can_view_create_form(): void
    {
        $user = User::factory()->create();
        Client::factory()->create(['name' => 'Joe Doe']);
        Client::factory()->create(['name' => 'Jane Doe']);

        $response = $this->actingAs($user)
            ->get(route('turbo.projects.create'));

        $response->assertOk()
            ->assertSee('Name')
            ->assertSee('Client')
            ->assertSee('Create');
    }

    #[Test]
    public function create_form_loads_client_search_component(): void
    {
        $user = User::factory()->create();
        Client::factory()->create(['name' => 'Jack Doe']);
        Client::factory()->create(['name' => 'Joe Doe']);

        $response = $this->actingAs($user)
            ->get(route('turbo.projects.create'));

        $response->assertOk()
            ->assertSee('Search or create client');
    }
}

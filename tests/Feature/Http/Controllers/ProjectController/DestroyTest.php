<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\ProjectController;

use App\Http\Controllers\ProjectController;
use App\Models\Project;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ProjectController::class)]
#[CoversMethod(ProjectController::class, 'destroy')]
final class DestroyTest extends TestCase
{
    #[Test]
    public function assert_auth_middleware_is_applied(): void
    {
        $project = Project::factory()->create();

        $response = $this->delete(route('projects.destroy', $project));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function user_can_delete_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['name' => 'Old Project']);

        $this->assertEquals(1, Project::count());

        $response = $this->actingAs($user)
            ->from(route('projects.index'))
            ->delete(route('projects.destroy', $project));

        $response->assertRedirect(route('projects.index'));

        $this->assertEquals(0, Project::count());
    }

    #[Test]
    public function deleting_project_shows_success_message(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['name' => 'Deleted Project']);

        $response = $this->actingAs($user)
            ->from(route('projects.index'))
            ->delete(route('projects.destroy', $project));

        $response->assertRedirect(route('projects.index'))
            ->assertSessionHas('flash');
    }

    #[Test]
    public function project_is_soft_deleted_if_soft_deletes_enabled(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $this->actingAs($user)
            ->delete(route('projects.destroy', $project));

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
            'deleted_at' => null,
        ]);
    }
}

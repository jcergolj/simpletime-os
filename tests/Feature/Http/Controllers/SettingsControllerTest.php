<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\SettingsController;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(SettingsController::class)]
final class SettingsControllerTest extends TestCase
{
    #[Test]
    public function auth_middleware_is_applied(): void
    {
        $response = $this->get(route('settings'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function user_can_view_settings_page(): void
    {
        $user = User::factory()->create(['name' => 'Joe Doe']);

        $response = $this->actingAs($user)->get(route('settings'));

        $response->assertOk()
            ->assertSee('Settings')
            ->assertSee('Joe Doe');
    }

    #[Test]
    public function settings_page_shows_user_information(): void
    {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
        ]);

        $response = $this->actingAs($user)->get(route('settings'));

        $response->assertOk()
            ->assertSee('Jane Doe');
    }

    #[Test]
    public function settings_page_has_navigation_links(): void
    {
        $user = User::factory()->create(['name' => 'Jack Doe']);

        $response = $this->actingAs($user)->get(route('settings'));

        $response->assertOk()
            ->assertSee('Profile')
            ->assertSee('Password')
            ->assertSee('Preferences');
    }
}

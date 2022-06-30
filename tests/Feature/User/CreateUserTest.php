<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_create_screen_can_not_be_rendered_by_guest()
    {
        $this->get('/users/user')
            ->assertRedirect('/login');
    }

    public function test_user_create_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/users/user')
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                $page->component('User/Create');
            });
    }

    public function test_user_can_not_be_created_by_guest()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->put("/users/user", $data)
            ->assertRedirect('/login');
    }

    public function test_user_can_be_created()
    {
        $user = User::factory()->create();

        Event::fake();

        $this->actingAs($user)
            ->put('/users/user', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ])->assertRedirect();

        Event::assertDispatched(Registered::class);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}

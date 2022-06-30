<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_edit_screen_can_not_be_rendered_by_guest()
    {
        $user = User::factory()->create();

        $this->get("/users/{$user->id}")
            ->assertRedirect('/login');
    }

    public function test_user_edit_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get("/users/{$user->id}")
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) use ($user) {
                $page->component('User/Edit')
                    ->has('user')
                    ->whereAll([
                        'user.id' => $user->id,
                        'user.name' => $user->name,
                        'user.email' => $user->email,
                    ]);
            });
    }

    public function test_user_can_not_be_updated_by_guest()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ];

        $this->post("/users/{$user->id}", $data)
            ->assertRedirect('/login');
    }

    public function test_user_can_be_updated()
    {
        $user = User::factory()->create();

        $data = [
            'name' => $user->name,
            'email' => $user->email,
        ];

        $this->actingAs($user)
            ->post("/users/{$user->id}", $data)
            ->assertRedirect('/users');
    }

    public function test_user_password_can_be_updated()
    {
        $user = User::factory()->create();
        $password = $user->password;

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ];

        $this->actingAs($user)
            ->post("/users/{$user->id}", $data)
            ->assertRedirect('/users');

        $this->assertNotEquals($password, $user->fresh()->password);
    }

    public function test_user_email_can_be_updated()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->assertNotNull($user->email_verified_at);

        $data = [
            'name' => $user->name,
            'email' => 'new+' . $user->email,
        ];

        $this->actingAs($user)
            ->post("/users/{$user->id}", $data)
            ->assertRedirect('/users');

        $user = $user->fresh();

        $this->assertEquals($data['email'], $user->email);
        $this->assertNull($user->email_verified_at);
    }
}
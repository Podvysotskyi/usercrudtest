<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_list_screen_can_not_be_rendered_by_guest()
    {
        $this->get('/users')
            ->assertRedirect('/login');
    }

    public function test_users_list_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/users')
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                $page->component('User/List')
                    ->has('users');
            });
    }
}

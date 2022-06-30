<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_screen_can_be_rendered_for_guest()
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                $page->component('Welcome')
                    ->hasAll(['canLogin', 'canRegister', 'canLogout'])
                    ->whereAll([
                        'canLogin' => true,
                        'canRegister' => true,
                    ])->where('canLogout', false);
            });
    }

    public function test_welcome_screen_can_be_rendered_for_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                $page->component('Welcome')
                    ->hasAll(['canLogin', 'canRegister', 'canLogout'])
                    ->where('canLogout', true);
            });
    }
}

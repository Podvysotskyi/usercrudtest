<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_deleted_by_guest()
    {
        $user = User::factory()->create();
        
        $this->delete("/users/{$user->id}")
            ->assertRedirect('/login');
    }

    public function test_user_can_not_delete_himself()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user)->delete("/users/{$user->id}")
            ->assertRedirect('/users');

        $this->assertModelExists($user);
    }

    public function test_user_can_be_deleted()
    {
        $user = User::factory()->create();
        $authUser = User::factory()->create();
        
        $this->actingAs($authUser)->delete("/users/{$user->id}")
            ->assertRedirect('/users');

        $this->assertModelMissing($user);
    }
}

<?php

namespace Tests\Unit;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_resource_format()
    {
        $user = User::factory()->make();

        $request = new Request();
        $resource = (new UserResource($user))->toArray($request);

        $this->assertIsArray($resource);
        $this->assertArrayHasKey('id', $resource);
        $this->assertArrayHasKey('name', $resource);
        $this->assertArrayHasKey('email', $resource);
        $this->assertArrayNotHasKey('password', $resource);
        $this->assertArrayNotHasKey('remember_token', $resource);
    }

    public function test_user_resource_collection_format()
    {
        User::factory()->count(10)->create();
        $users = User::paginate(5);

        $request = new Request();
        $response = UserResource::collection($users)->toResponse($request);
        $json = (array)$response->getData();
        
        $this->assertIsArray($json);
        $this->assertArrayHasKey('data', $json);
        $this->assertCount(5, $json['data']);
        $this->assertArrayHasKey('links', $json);
        $this->assertArrayHasKey('meta', $json);
    }
}

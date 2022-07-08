<?php

namespace Tests\Unit;

use App\Http\Middleware\HandleInertiaRequests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InertiaMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_inertai_middleware_data_does_not_have_user_for_guest()
    {
        $request = new Request();

        $middleware = new HandleInertiaRequests();

        $data = $middleware->share($request);

        $this->assertArrayHasKey('auth', $data);
        $this->assertArrayHasKey('user', $data['auth']);
        $this->assertNull($data['auth']['user']);
    }

    public function test_inertai_middleware_data_has_user()
    {
        $user = User::factory()->create();

        $request = new Request();
        $request->setUserResolver(fn () => $user);

        $middleware = new HandleInertiaRequests();
        $data = $middleware->share($request);

        $this->assertArrayHasKey('auth', $data);
        $this->assertArrayHasKey('user', $data['auth']);

        $this->assertEquals($data['auth']['user']['id'], $user->id);
        $this->assertEquals($data['auth']['user']['name'], $user->name);
        $this->assertEquals($data['auth']['user']['email'], $user->email);

        $this->assertArrayNotHasKey('password', $data['auth']['user']);
        $this->assertArrayNotHasKey('remember_token', $data['auth']['user']);
    }
}

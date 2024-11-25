<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

abstract class TestCase extends BaseTestCase
{
    public function authRequest($method, $route, $status = 200, $request = [], $user = null): \Illuminate\Testing\TestResponse
    {
        return $this->withHeaders([
            'Authorization' => 'Bearer '.$this->generateToken($user),
        ])->simpleRequest(
            $method,
            $route,
            $status,
            $request
        );
    }

    public function simpleRequest($method, $route, $status = 200, $request = []): \Illuminate\Testing\TestResponse
    {
        $response = $this->json($method,
            $route,
            $request
        );

        if ($status === 0) {
            return $response;
        }

        if ($response->status() !== $status) {
            dump($response->json());
        }
        $response->assertStatus($status);

        return $response;
    }

    public function simpleTest($method, $route, $status = 200, $request = [], $user = null, $protected = true)
    {
        if ($protected) {
            $this->isProtected($method, $route, $request);
        }

        return $this->authRequest($method, $route, $status, $request, $user);
    }

    public function isProtected($method, $route, $request = [])
    {
        if (Auth::check()) {
            foreach (config('auth.guards') as $guardName => $guardConfig) {
                $guard = Auth::guard($guardName);
                if (method_exists($guard, 'forgetUser')) {
                    $guard->forgetUser();
                }
            }
        }
        $this->assertGuest();

        $response = $this->json($method,
            $route,
            $request,
        );
        $response->assertStatus(401);
    }

    public function generateToken($user = null): string
    {
        $user = $user ?: User::factory()->create();

        return $user->createToken('apiToken')->plainTextToken;
    }

    public function removeTestFiles($path): void
    {
        $path = public_path('storage/'.$path);
        $path = str_replace('\\', '/', $path);

        if (File::exists($path) && config('app.remove_test_files', true)) {
            File::delete($path);
        }
    }
}

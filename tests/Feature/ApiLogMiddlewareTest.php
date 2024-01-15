<?php

namespace Tests\Feature;

use App\Http\Middleware\ApiResponseMiddleware;
use App\Jobs\SendFailedNotificationToAdmin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Request;
use Tests\TestCase;

class ApiLogMiddlewareTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function it_logs_api_call_and_sends_email_on_failure(): void
    {

        Notification::fake();

        $user = User::factory()->create();

        $request = Request::create('/test-endpoint', 'GET');

        $this->actingAs($user);

        $response = response()->json(['error' => 'Not Found'], 404);

        $middleware = new ApiResponseMiddleware();

        $middleware->handle($request, function () use ($response) {
            return $response;
        });

        $this->assertDatabaseHas('http_request_log', [
            'user_id' => $user->id,
            'is_successful' => 0,
            'response_status' => $response->status(),
        ]);

        Notification::assertSentTo([$user], SendFailedNotificationToAdmin::class);
    }
}

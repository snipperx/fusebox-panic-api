<?php

namespace Tests\Feature;

use App\Services\HttpClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExternalApiConnectorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_makes_api_request_successfully()
    {
        $base_url = 'https://wayne.fusebox-staging.co.za/api/v1';

        $apiConnector = new HttpClient('your_api_base_url', 'your_api_key');

        Http::fake([
            'your_api_base_url/your_endpoint' => Http::response(['data' => 'example_response'], 200),
        ]);

        $method = 'POST';
        $endpoint = '/your_endpoint';
        $data = ['key' => 'value'];

        $result = $apiConnector->makeApiRequest($method, $endpoint, $data);
        $this->assertEquals(['data' => 'example_response'], $result);
    }

    /** @test */
    public function it_handles_api_request_failure()
    {

        $apiConnector = new HttpClient('your_api_base_url', 'your_api_key');
        Http::fake([
            'your_api_base_url/your_endpoint' => Http::throw(),
        ]);
        $method = 'POST';
        $endpoint = '/your_endpoint';
        $data = ['key' => 'value'];

        $result = $apiConnector->makeApiRequest($method, $endpoint, $data);
        $this->assertTrue($result['error']);
        $this->assertStringContainsString('HTTP request failed', $result['Message']);
    }
}

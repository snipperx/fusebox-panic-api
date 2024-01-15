<?php

namespace App\Services;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Http;

class HttpClient
{

    private string $apiBaseUrl;
    private string $apiKey;

    public function __construct(Repository $config)
    {
        $this->config = $config;
        $this->apiBaseUrl = $this->config->get('services.third_party_api.base_url');
        $this->apiKey = $this->config->get('services.third_party_api.api_key');
    }

    public function makeApiRequest(string $method, string $endpoint, array $data = []): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '. $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiBaseUrl. $endpoint, $data);

            return json_decode($response, true);
        } catch (\Throwable $e) {
            // Handle any exceptions that may occur during the API request
            // For example, you could log the error and return an error response
            return [
                'error' => true,
                'Message' => $e->getMessage(),
            ];
        }
    }
}

<?php

namespace App\Jobs;

use App\Events\ApiCallCompleted;
use App\Services\HttpClient;
use Illuminate\Config\Repository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreatePanicJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;


    private mixed $requestData;
    private array $response;

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    public function handle(HttpClient $thirdPartyApiService)
    {
        $this->response = $thirdPartyApiService->makeApiRequest('post', '/panic/create', $this->requestData);
    }

    public function getResponse()
    {
        return $this->response;
    }
}

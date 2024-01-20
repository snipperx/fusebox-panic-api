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
use Illuminate\Support\Facades\Log;

class CreatePanicJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private mixed $requestData;
    private array $response;

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    public function handle(HttpClient $thirdPartyApiService)
    {
        $response = $thirdPartyApiService->makeApiRequest('post', '/panic/create', $this->requestData);
        cache()->put('create_panic_result', $response);
        return response()->json(['message' => 'Job completed successfully', 'result' => $response]);
    }



    public function failed($exception)
    {
        Log::error('MyJob failed: '. $exception->getMessage());
    }
}

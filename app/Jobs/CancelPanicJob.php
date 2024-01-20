<?php

namespace App\Jobs;

use App\Services\HttpClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CancelPanicJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private mixed $requestData;
    private $response;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * Execute the job.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(HttpClient $thirdPartyApiService)
    {
        $response =  $thirdPartyApiService->makeApiRequest('post', '/panic/cancel', $this->requestData);
        cache()->put('cancel_panic_result', $response); // cache the response to display to user
        return response()->json(['message' => 'Job completed successfully', 'result' => $response]);
    }

    public function failed($exception)
    {
        Log::error('MyJob failed: '. $exception->getMessage());
    }
}

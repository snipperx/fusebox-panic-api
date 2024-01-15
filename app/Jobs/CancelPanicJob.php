<?php

namespace App\Jobs;

use App\Services\HttpClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelPanicJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

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
     * @return void
     */
    public function handle(HttpClient $thirdPartyApiService)
    {
        $this->response =  $thirdPartyApiService->makeApiRequest('post', '/panic/cancel', $this->requestData);
    }

    public function getResponse()
    {
       return $this->response;
    }
}

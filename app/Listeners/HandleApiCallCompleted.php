<?php

namespace App\Listeners;

use App\Events\ApiCallCompleted;
use App\Models\Panic;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleApiCallCompleted
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ApiCallCompleted  $event
     * @return void
     */
    public function handle(ApiCallCompleted $event)
    {
        dd($event->longitude);
        $apiResponse = $event->apiResponse;

        // Access the necessary data from the API response
        $longitude = $apiResponse['longitude'] ?? null;
        $latitude = $apiResponse['latitude'] ?? null;
        $panicType = $apiResponse['panic_type'] ?? null;
        $details = $apiResponse['details'] ?? null;
        $userName = $apiResponse['user_name'] ?? null;
        $referenceId = $apiResponse['reference_id'] ?? null;

        // Save data into the panic table
        Panic::create([
            'longitude' => $longitude,
            'latitude' => $latitude,
            'panic_type' => $panicType,
            'details' => $details,
            'user_name' => $userName,
            'reference_id' => $referenceId,
        ]);

    }
}

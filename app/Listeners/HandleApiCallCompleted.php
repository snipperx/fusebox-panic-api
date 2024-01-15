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
    public function handle()
    {


    }
}

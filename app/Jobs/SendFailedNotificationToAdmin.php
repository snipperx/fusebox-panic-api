<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ApiCallFailedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFailedNotificationToAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $url;
    public $requestData;
    public $errorMessage;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $requestData, $errorMessage)
    {
        $this->url = $url;
        $this->requestData = $requestData;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            $admin->notify(new ApiCallFailedNotification($this->url, $this->requestData, $this->errorMessage));
        }
    }
}

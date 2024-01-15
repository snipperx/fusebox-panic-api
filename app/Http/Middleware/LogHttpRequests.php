<?php

namespace App\Http\Middleware;

use App\Jobs\SendFailedNotificationToAdmin;
use App\Models\HttpRequestLog;
use App\Notifications\ApiCallFailedNotification;
use Closure;
use HttpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogHttpRequests
{

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $this->logApiCall($request, $response);
//        // Check for API failure and send email notification
        if ($response->status() >= 400) {
            $this->sendApiFailureEmail($request, $response);
        }

        return $response;
    }

    /**
     * @param $request
     * @param $response
     * @return void
     */
    private function logApiCall($request, $response)
    {
        $logData = [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'request_headers' => json_encode($request->headers->all()),
            'request_body' => json_encode($request->all()),
            'response_status' => $response->status(),
            'is_successful' => $response->status() === 200 ? 1 : 0,
            'response_body' => $response->getContent(),
            'user_id'  => Auth::id(),
        ];

        HttpRequestLog::create($logData);
        Log::info('API Activity', $logData);
    }

    /**
     * @param $request
     * @param $response
     * @return void
     */
    private function sendApiFailureEmail($request, $response)
    {
        $requestData = $request->all();
        $errorMessage = $response->statusText();
        SendFailedNotificationToAdmin::dispatch($request->fullUrl(), $requestData, $errorMessage);
    }
}

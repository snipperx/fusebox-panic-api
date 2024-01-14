<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiResponse;
use Closure;
use Illuminate\Http\Request;

class ApiResponseMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Check if the response is a JSON response
        if ($response->headers->get('Content-Type') === 'application/json') {
            // Modify the response structure using the ApiResponse class
            return ApiResponse::make(
                $response->getData()->status ?? 'success',
                $response->getData()->message ?? 'Action completed successfully',
                array($response->getData()->data ?? null),
                $response->getStatusCode()
            );
        }

        return $response;
    }
}

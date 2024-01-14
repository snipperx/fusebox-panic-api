<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register the ApiResponseMiddleware
        $this->app['router']->aliasMiddleware('api.response', \App\Http\Middleware\ApiResponseMiddleware::class);

        // Register the api macro
        Response::macro('api', function ($status, $message = '', $data = null, $code = 200) {
            return response()->json([
                'status' => $status,
                'message' => $message ?: ($status == 'success' ? 'Action completed successfully' : 'An error occurred'),
                'data' => $data,
            ], $code);
        });
    }

}

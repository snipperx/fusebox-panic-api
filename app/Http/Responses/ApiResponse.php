<?php

namespace App\Http\Responses;

class ApiResponse
{
    public static function make($status, $message = '', $data = null, $code = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message ?: ($status == 'success' ? 'Action completed successfully' : 'An error occurred'),
            'data' => $data,
        ], $code);
    }
}

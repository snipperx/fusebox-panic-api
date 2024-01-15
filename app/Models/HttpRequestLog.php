<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HttpRequestLog extends Model
{
    use HasFactory;

    protected $table='http_request_log';

    protected $fillable = [
        'method', 'ip', 'request_headers','is_successful','url','user_id',
        'request_body', 'response_status', 'response_body','is_successful',
    ];
}

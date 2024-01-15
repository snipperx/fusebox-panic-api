<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\V1\Panics\PanicController;
use App\Jobs\CreatePanicJob;
use App\Models\Panic;
use App\Models\User;
use App\Services\PanicAlertService;
use http\Client\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class PanicControllerTest extends TestCase
{
    
}

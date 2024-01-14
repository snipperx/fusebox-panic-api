<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Responses\ApiResponse;
use App\Http\Validators\UserValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    private UserValidator $userValidator;

    public function __construct(UserValidator $userValidator,)
    {
        $this->userValidator = $userValidator;
    }
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $validateUser = $this->userValidator->validateLoginUser($request->all());

        if($validateUser->fails()){
            return ApiResponse::make('error', 'validation failure – missing/incorrect variables', '', 500);
        }

        try {

            if(!Auth::attempt($request->only(['email', 'password']))){
                return ApiResponse::make('error', 'unauthorised', '', 401);
            }

            $request->authenticateOrFail();

            $token = $this->genarateToken();

            return ApiResponse::make('success',
                'Action completed successfully',
                $token ,200);

        } catch (\Throwable $th) {
            return ApiResponse::make('error', $th->getMessage(), '', 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->revokeToken();
            return ApiResponse::make('success',
                'Logged out',
                "" ,200);
        } catch (\Throwable $th) {
            return ApiResponse::make('error', $th->getMessage(), '', 500);
        }
    }


    public function userInfo()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }

    private function revokeToken()
    {
        $user = Auth::user();
        $user->tokens()->delete();
    }


    private function genarateToken()
    {
        return Auth::user()
            ->createToken('api_token')
            ->accessToken;
    }
}

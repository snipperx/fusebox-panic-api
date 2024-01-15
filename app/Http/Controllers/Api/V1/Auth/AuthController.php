<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Http\Responses\ApiResponse;
use App\Http\Validators\UserValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;


class AuthController extends Controller
{
    private UserValidator $userValidator;

    public function __construct(UserValidator $userValidator,)
    {
        $this->userValidator = $userValidator;
    }


    /**
     * Login The User
     * @param LoginRequest $request
     * @return JsonResponse
     * @OA\Post(
     *     path="auth/login",
     *     tags={"Login"},
     *     summary="Authenticate user and generate JWT token",
     *     operationId="login",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=true,
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *   @OA\Response(
     *       response=200,
     *        description="Success",
     *       @OA\MediaType(
     *            mediaType="application/json",
     *       )
     *    ),
     *    @OA\Response(
     *       response=401,
     *        description="Unauthenticated"
     *    ),
     *    @OA\Response(
     *       response=400,
     *       description="Bad Request"
     *    ),
     *    @OA\Response(
     *       response=404,
     *       description="not found"
     *    ),
     *     @OA\Response(
     *           response=403,
     *           description="Forbidden"
     *       )
     * )
     */

    public function login(LoginRequest $request): JsonResponse
    {
        try {
//            $this->userValidator->validateLogin($request);
            $validated = $request->validated();

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return ApiResponse::make('error', 'Invalid credentials', '', 401);
            }

            $request->authenticateOrFail();

            $token = $this->genarateToken();

            return ApiResponse::make('success', 'Login successful', ['token' => $token], 200);
        } catch (\Throwable $th) {
            return ApiResponse::make('error', $th->getMessage(), '', 500);
        }
    }


    /*
  * log the author out
  *
  * @OA\Get(
  *      path="/logoutUser",
  *      operationId="logoutUser",
  *      tags={"users"},
  *      summary="Log out an existing user",
  *      description="Logs out a logged in user",
  *      @OA\Response(
  *          response=200,
  *          description="Successful operation",
  *          @OA\JsonContent(ref="App\Http\Resources\Api\V1\UsersResource")
  *       ),
  *      @OA\Response(
  *          response=401,
  *          description="Unauthenticated",
  *      ),
  *      @OA\Response(
  *          response=403,
  *          description="Forbidden"
  *      )
  *     )
  */
    public function logout(Request $request)
    {
        try {
            $this->revokeToken();
            return ApiResponse::make('success',
                'Logged out',
                "", 200);
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

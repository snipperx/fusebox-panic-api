<?php

namespace App\Http\Controllers\Api\V1\Panics;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePanicRequest;
use App\Http\Requests\PanicRequest;
use App\Http\Resources\Api\V1\PanicResource;
use App\Http\Responses\ApiResponse;
use App\Http\Validators\CreatePanicValidator;
use App\Jobs\CancelPanicJob;
use App\Jobs\CreatePanicJob;
use App\Models\Panic;
use App\Services\PanicAlertService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;
use OpenApi\Annotations as OA;

class PanicController extends Controller
{
    private CreatePanicValidator $panicValidator;
    private PanicAlertService $alertService;

    public function __construct(
        CreatePanicValidator $panicValidator,
        PanicAlertService    $alertService
    )
    {
        $this->panicValidator = $panicValidator;
        $this->alertService = $alertService;
    }



    /**
     * @OA\Post(
     *      path="/panics/create",
     *      operationId="createPanic",
     *      tags={"Panics"},
     * security={
     *  {"passport": {}},
     *   },
     *      summary="Create  New Panic Alert",
     *      description="Creates New Alert",
     *     @OA\Parameter(
     *       name="longitude",
     *       in="query",
     *       required=true,
     *       @OA\Schema(
     *            type="string"
     *       )
     *    ),
     *       @OA\Parameter(
     *       name="latitude",
     *       in="query",
     *       required=true,
     *       @OA\Schema(
     *            type="string"
     *       )
     *    ),
     *   @OA\Parameter(
     *       name="panic_type",
     *       in="query",
     *       required=false,
     *       @OA\Schema(
     *            type="string"
     *       )
     *    ),
     *     @OA\Parameter(
     *        name="details",
     *        in="query",
     *        required=false,
     *        @OA\Schema(
     *             type="text"
     *        )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function createPanic(Request $request): JsonResponse
    {
        try {

            $validator = $this->panicValidator->validatePanicAlert($request->all());

            if ($validator->fails()) {
                return ApiResponse::make('error', $validator->errors(), '', 401);
            }

            $createPanicJob = new CreatePanicJob($request->all());

            $this->dispatchSync($createPanicJob);

            $responseArray = $createPanicJob->getResponse();

            $this->alertService->persistPanicData($request->all(), $responseArray['data']['panic_id']);

            return response()->json($createPanicJob->getResponse());
        } catch (\Throwable $th) {
            return ApiResponse::make('error', $th->getMessage(), '', 500);
        }
    }


    /**
     * @OA\Post(
     ** path="/panics/cancel",
     *   tags={"Panics"},
     *   summary="Cancel Panic",
     *   operationId="cancelPanic",
     *
     *   @OA\Parameter(
     *      name="panic_id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function cancelPanicAlert(): JsonResponse
    {
        try {
            $panic = Panic::getPanicId();
            $cancelPanicJob = new CancelPanicJob(array('panic_id' => $panic->panic_id));
            $this->dispatchSync($cancelPanicJob);
            $responseArray = $cancelPanicJob->getResponse();
            //log user who cancelled
            Log::info('User with ID' . $panic->panic_id . 'canceled the panic"',
                $cancelPanicJob->getResponse());

            return response()->json($cancelPanicJob->getResponse());
        } catch (\Throwable $th) {
            return ApiResponse::make('error', $th->getMessage(), '', 500);
        }
    }


    /**
     * Display the specified resource.
     * @OA\Get(
     *      path="/api/panics/panic-history",
     *      operationId="showPanics",
     *      tags={"Panics"},
     *      summary="Get Panic History",
     *      description="Get Panic History",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="App/Http/Resources/Api/V1/PanicResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="validation failure – missing/incorrect variables",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      )
     *     )
     */
    public function getUserNotificationHistory(): JsonResponse
    {
        $panics = ['panics' => PanicResource::collection(Panic::getNotificationHistoryForUser())];
        return ApiResponse::make(
            'success',
            'Action completed successfully',
            $panics,
            200);
    }

}

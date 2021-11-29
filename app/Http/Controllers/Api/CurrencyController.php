<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Currency\CurrencyRequest;
use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(title="API Currency", version="1.0")
 */
class CurrencyController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/currency",
     *     summary="Get All Currencies",
     *     @OA\Response(
     *         response=200,
     *         description="Get All Currencies"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(Currency::all()->toArray(), Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/currency/convert",
     *     summary="Convert Value To Specific Currency",
     *     @OA\Parameter(
     *         name="value",
     *         in="query",
     *         description="Value to Convert",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="from",
     *         in="query",
     *         description="Currency From Convert",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="to",
     *         in="query",
     *         description="Currency To Convert",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get Currency of values passed"
     *     )
     * )
     *
     */
    public function convert(CurrencyRequest $request, CurrencyService $currencyService): JsonResponse
    {
        $currency = $currencyService->convert($request->value, $request->from, $request->to);
        if ($currency) {
            return response()->json($currency, Response::HTTP_OK);
        }
        return response()->json(['message' => 'Not Found'], Response::HTTP_NOT_FOUND);
    }

    /**
     * @OA\Get(
     *     path="/api/currency/convertMultiple",
     *     summary="Convert Values To Multiples Currencies",
     *     @OA\Parameter(
     *         name="value",
     *         in="query",
     *         description="Value to Convert",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="from",
     *         in="query",
     *         description="Currency From Convert",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="to",
     *         in="query",
     *         description="Currencies To Convert",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get Currency of values passed"
     *     )
     * )
     *
     */
    public function convertToMultipleSource(CurrencyRequest $request, CurrencyService $currencyService): JsonResponse
    {
        $currency = $currencyService->convertToMultipleSource($request->value, $request->from, explode(',', $request->to));
        return response()->json($currency, Response::HTTP_OK);
    }
}

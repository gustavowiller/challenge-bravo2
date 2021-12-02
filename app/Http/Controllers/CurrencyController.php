<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvertRequest;
use App\Http\Requests\PostCurrency;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    /**
     * @var CurrencyService $currencyService
     */
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function post(PostCurrency $request)
    {
        $currency = $this->currencyService->create($request->validated());

        return response($currency, 201);
    }

    public function convert(ConvertRequest $request)
    {
        $conversion = $request->validated();

        $result = $this->currencyService->convertExchangeRates(
            $conversion["from"],
            $conversion["to"],
            $conversion["amount"]
        );

        return response([
            "result" => $result
        ]);
    }
}

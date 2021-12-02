<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvertRequest;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    public function convert(ConvertRequest $request)
    {
        $conversion = $request->validated();

        $currencyService = new CurrencyService;
        $result = $currencyService->convertExchangeRates(
            $conversion["from"],
            $conversion["to"],
            $conversion["amount"]
        );

        return response([
            "result" => $result
        ]);
    }
}

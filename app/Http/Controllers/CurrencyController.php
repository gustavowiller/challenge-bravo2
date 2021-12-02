<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvertRequest;
use App\Http\Requests\PostCurrency;
use App\Services\CurrencyService;
use App\Services\ExchangeRateService;
use Illuminate\Support\Facades\Request;

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
        $fields = $request->validated();

        if ($request->get("is_real")) {
            $exchangeRateService = new ExchangeRateService();
            $fields["exchange_rate"] = $exchangeRateService->getRateBy($request->get("code"));
        }

        $currency = $this->currencyService->create($fields);

        return response($currency, 201);
    }

    public function delete(Request $request, string $code)
    {
        if (!$this->currencyService->existsCurrency($code)) {
            abort(404);
        }

        $this->currencyService->deleteCurrency($code);

        return response()->noContent();
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

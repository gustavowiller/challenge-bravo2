<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Redis;

class CurrencyService
{
    public function create(array $fields)
    {
        return Currency::create($fields);
    }

    public function convertExchangeRates(
        string $codeFrom,
        string $codeTo,
        float $amount
    ): float {
        $exchangeRateFrom = $this->getExchangeRate($codeFrom);
        $exchangeRateTo = $this->getExchangeRate($codeTo);

        return $amount * $exchangeRateTo / $exchangeRateFrom;
    }

    public function existsCurrency(string $code): bool
    {
        return Currency::where("code", $code)->exists();
    }

    public function deleteCurrency(string $code): void
    {
        $currency = Currency::where("code_", $code)->first();
        $currency->delete();
    }

    protected function getExchangeRate(string $codeCurrency): float
    {
        $cachedExchangeRate = Redis::get("code_{$codeCurrency}");

        if ($cachedExchangeRate) {
            return (float) $cachedExchangeRate;
        }

        $currency = Currency::where("code", $codeCurrency)->first();

        if (!$currency) {
            abort(422, "The selected currency:{$codeCurrency} is invalid.");
        }

        Redis::set("code_{$codeCurrency}", $currency["exchange_rate"]);

        return $currency["exchange_rate"];
    }

    public function updateAllRates(): void
    {
        $rates = app(ExchangeRateService::class)->getAll();

        $currencies = Currency::real()->get();
        foreach ($currencies as $currency) {
            $rate = $rates[$currency->code] ?? null;

            $currency->update([
                "exchange_rate" => $rate
            ]);
        }
    }
}

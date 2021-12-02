<?php

namespace App\Services;

use App\Models\Currency;

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

    public function existsCurrency(string $code)
    {
        return Currency::where("code", $code)->exists();
    }

    public function deleteCurrency(string $code): void
    {
        $currency = Currency::where("code", $code)->first();
        $currency->delete();
    }

    protected function getExchangeRate(string $codeCurrency): float
    {
        return Currency::where("code", $codeCurrency)->first()['exchange_rate'];
    }
}

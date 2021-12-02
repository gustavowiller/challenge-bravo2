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

    public function existsCurrency(string $codeCurrency)
    {
        return Currency::where("code", $codeCurrency)->exists();
    }

    protected function getExchangeRate(string $codeCurrency): float
    {
        return Currency::where("code", $codeCurrency)->first()['exchange_rate'];
    }
}

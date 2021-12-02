<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExchangeRateService
{
    const BASE_CURRENCY = "USD";
    const URL_EXTERNAL_API = "https://api.coinbase.com/v2";

    public function getAll(): array
    {
        $url = sprintf("%s/exchange-rates?currency=%s", self::URL_EXTERNAL_API, self::BASE_CURRENCY);

        $response = Http::get($url);

        return $response->json()["data"]["rates"];
    }

    public function getRateBy(string $codeCurrency): ?float
    {
        return $this->getAll()[$codeCurrency] ?? null;
    }
}

<?php

namespace Tests\Feature;

use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetCurrencyConvertTest extends TestCase
{
    use RefreshDatabase;

    protected $routeUrl = "api/currency/convert/";

    public function test_get_currency_convert()
    {
        Currency::create([
            'code' => 'USD',
            'exchange_rate' => 1
        ]);

        Currency::create([
            'code' => 'BR',
            'exchange_rate' => 5.64
        ]);

        $response = $this->get($this->routeUrl . "?from=USD&to=BR&amount=2.1");
        $response->assertOk();
    }

    public function test_get_currency_convert_with_invalid_params_expects_422()
    {
        $invalidCurrency = "CODE-WITH-SYMBOLS";
        $response = $this->get(
            sprintf($this->routeUrl . "?from=%s&to=BR&amount=2.1", $invalidCurrency)
        );

        $response->assertUnprocessable();

        $this->assertArrayHasKey("errors", $response->decodeResponseJson());
    }

    public function test_get_currency_convert_with_non_existent_currency_expects_422()
    {
        $inexistentCurrency = "AADDF";
        $response = $this->get(
            sprintf($this->routeUrl . "?from=%s&to=BR&amount=2.1", $inexistentCurrency)
        );

        $response->assertUnprocessable();

        $this->assertArrayHasKey("errors", $response->decodeResponseJson());
    }

    public function test_get_currency_convert_with_valid_currencies()
    {
        Currency::create([
            'code' => 'USD',
            'exchange_rate' => 1
        ]);

        Currency::create([
            'code' => 'BR',
            'exchange_rate' => 5.64
        ]);

        $amount = 2;

        $response = $this->get(
            sprintf($this->routeUrl . "?from=USD&to=BR&amount=%f", $amount)
        );

        $response->assertOk();

        $this->assertArrayHasKey("result", $response->decodeResponseJson());
        $this->assertSame(11.28, $response->decodeResponseJson()["result"]);
    }
}

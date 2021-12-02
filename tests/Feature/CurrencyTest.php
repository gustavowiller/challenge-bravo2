<?php

namespace Tests\Feature;

use App\Models\Currency;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    public function test_get_endpoint_convert_currency()
    {
        Currency::create(['code'=>'USD']);
        Currency::create(['code'=>'BR']);

        $response = $this->get("api/currency/convert/?from=USD&to=BR&amount=2.1");
        $response->assertOk();
    }

    public function test_get_endpoint_with_invalid_params_expects_422()
    {
        $invalidCurrency = "CODE-WITH-SYMBOLS";
        $response = $this->get(
            sprintf("api/currency/convert/?from=%s&to=BR&amount=2.1", $invalidCurrency)
        );

        $response->assertUnprocessable();

        $this->assertArrayHasKey("errors", $response->decodeResponseJson());
    }

    public function test_get_endpoint_with_non_existent_currency_expects_422()
    {
        $inexistentCurrency = "AADDF";
        $response = $this->get(
            sprintf("api/currency/convert/?from=%s&to=BR&amount=2.1", $inexistentCurrency)
        );

        $response->assertUnprocessable();

        $this->assertArrayHasKey("errors", $response->decodeResponseJson());
    }
}

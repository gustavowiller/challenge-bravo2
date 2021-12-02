<?php

namespace Tests\Feature;

use Tests\TestCase;

class CurrencyTest extends TestCase
{
    public function test_get_endpoint_convert_currency()
    {
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
}

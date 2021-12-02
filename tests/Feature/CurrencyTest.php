<?php

namespace Tests\Feature;

use Tests\TestCase;

class CurrencyTest extends TestCase
{
    public function test_get_endpoint_convert_currency()
    {
        $response = $this->get("api/currency/convert?from=USD&to=BR&amount=2.1");
        $response->assertOk();
    }
}

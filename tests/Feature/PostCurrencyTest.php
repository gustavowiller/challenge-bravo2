<?php

namespace Tests\Feature;

use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostCurrencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_without_params_expects_422()
    {
        $response = $this->post('api/currency');

        $response->assertUnprocessable();
        $this->assertArrayHasKey("errors", $response->decodeResponseJson());
    }

    public function test_post_valid_params_to_create_new_currency()
    {
        $currency = [
            "code" => "BR",
            "exchange_rate" => 5.3
        ];

        $this->assertSame(0, Currency::count());
        $response = $this->post('api/currency', $currency);

        $this->assertSame(1, Currency::count());
        $currencyCreated = $response->decodeResponseJson();

        $this->assertSame($currency["code"], $currencyCreated["code"]);
        $this->assertSame($currency["exchange_rate"], $currencyCreated["exchange_rate"]);

        $response->assertCreated();
    }

    public function test_post_with_invalid_params_expects_422()
    {
        $response = $this->post('api/currency', [
            "code" => "BRasdf1",
            "exchange_rate" => "asd"
        ]);

        $response->assertUnprocessable();
        $this->assertArrayHasKey("errors", $response->decodeResponseJson());
    }

    public function test_validates_if_there_already_currency_record()
    {
        Currency::create([
            "code" => "BR",
            "exchange_rate" => 5
        ]);

        $response = $this->post('api/currency', [
            "code" => "BR",
            "exchange_rate" => 5.1
        ]);

        $response->assertUnprocessable();
        $this->assertArrayHasKey("errors", $response->decodeResponseJson());
    }
}

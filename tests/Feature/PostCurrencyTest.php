<?php

namespace Tests\Feature;

use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostCurrencyTest extends TestCase
{
    use RefreshDatabase;

    protected $routeUrl = "api/currency";

    public function test_post_without_params_expects_422()
    {
        $response = $this->post($this->routeUrl);

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
        $response = $this->post($this->routeUrl, $currency);

        $this->assertSame(1, Currency::count());
        $currencyCreated = $response->decodeResponseJson();

        $this->assertSame($currency["code"], $currencyCreated["code"]);
        $this->assertSame($currency["exchange_rate"], $currencyCreated["exchange_rate"]);

        $response->assertCreated();
    }

    public function test_post_with_invalid_params_expects_422()
    {
        $response = $this->post($this->routeUrl, [
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

        $response = $this->post($this->routeUrl, [
            "code" => "BR",
            "exchange_rate" => 5.1
        ]);

        $response->assertUnprocessable();
        $this->assertArrayHasKey("errors", $response->decodeResponseJson());
    }

    public function test_recreate_same_currency()
    {
        $currency = [
            "code" => "BR",
            "exchange_rate" => 5.3
        ];

        $response = $this->post($this->routeUrl, $currency);
        $response->assertCreated();

        $response = $this->delete("api/currency/" . $currency["code"]);
        $response->assertNoContent();

        $response = $this->post($this->routeUrl, $currency);
        $response->assertCreated();
    }
}

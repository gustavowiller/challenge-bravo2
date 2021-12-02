<?php

namespace Tests\Feature;

use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostCurrencyTest extends TestCase
{
    use RefreshDatabase;

    protected $routeUrl = "api/currency";

    protected $exampleCurrency = [
        "code" => "BR",
        "exchange_rate" => 5.3
    ];

    public function test_post_without_params_expects_422()
    {
        $response = $this->post($this->routeUrl);

        $response->assertUnprocessable();
        $this->assertArrayHasKey("errors", $response->decodeResponseJson());
    }

    public function test_post_valid_params_to_create_new_currency()
    {
        $this->assertSame(0, Currency::count());
        $response = $this->post($this->routeUrl, $this->exampleCurrency);

        $this->assertSame(1, Currency::count());
        $currencyCreated = $response->decodeResponseJson();

        $this->assertSame($this->exampleCurrency["code"], $currencyCreated["code"]);
        $this->assertSame($this->exampleCurrency["exchange_rate"], $currencyCreated["exchange_rate"]);

        $response->assertCreated();
    }

    public function test_post_with_invalid_params_expects_422()
    {
        $invalidCurrency = [
            "code" => "BRasdf1",
            "exchange_rate" => "asd"
        ];

        $response = $this->post($this->routeUrl, $invalidCurrency);

        $response->assertUnprocessable();
        $this->assertArrayHasKey("errors", $response->decodeResponseJson());
    }

    public function test_validates_if_there_already_currency_record()
    {
        Currency::create($this->exampleCurrency);

        $response = $this->post($this->routeUrl, $this->exampleCurrency);

        $response->assertUnprocessable();
        $this->assertArrayHasKey("errors", $response->decodeResponseJson());
    }

    public function test_recreate_same_currency()
    {
        $response = $this->post($this->routeUrl, $this->exampleCurrency);
        $response->assertCreated();

        $response = $this->delete("api/currency/" . $this->exampleCurrency["code"]);
        $response->assertNoContent();

        $response = $this->post($this->routeUrl, $this->exampleCurrency);
        $response->assertCreated();
    }
}

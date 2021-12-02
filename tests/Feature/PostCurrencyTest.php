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
        $response = $this->post('api/currency', [
            "code" => "BR",
            "exchange_rate" => 5.3
        ]);

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

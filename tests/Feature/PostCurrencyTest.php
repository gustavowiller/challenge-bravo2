<?php

namespace Tests\Feature;

use Tests\TestCase;

class PostCurrencyTest extends TestCase
{
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
}

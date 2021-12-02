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
}

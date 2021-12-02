<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCurrencyTest extends TestCase
{
    use RefreshDatabase;

    protected $routeUrl = "api/currency/%s";

    public function test_delete_non_existent_currency_expects_404()
    {
        $nonExistentCurrency = "BRBRBRBRAS";

        $response = $this->delete(sprintf($this->routeUrl, $nonExistentCurrency));

        $response->assertNotFound();
    }
}

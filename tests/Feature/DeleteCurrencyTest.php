<?php

namespace Tests\Feature;

use App\Models\Currency;
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

    public function test_delete_currency()
    {
        Currency::create([
            'code' => 'USD',
            'exchange_rate' => 1
        ]);

        $this->assertSame(1, Currency::count());
        $response = $this->delete(sprintf($this->routeUrl, 'USD'));

        $response->assertNoContent();
        $this->assertSame(0, Currency::count());
    }
}

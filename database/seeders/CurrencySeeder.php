<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currenciesCode = ["USD", "BRL", "EUR", "BTC", "ETH"];

        foreach ($currenciesCode as $code) {
            Currency::create([
                "code" => $code,
                "is_real" => true
            ]);
        }
    }
}

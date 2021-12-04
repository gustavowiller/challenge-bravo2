<?php

namespace App\Console\Commands;

use App\Services\CurrencyService;
use Illuminate\Console\Command;

class UpdateExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange_rate:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates our base exchange rates according to current exchange values';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        app(CurrencyService::class)->updateAllRates();
        $this->info('Updated all exchange rates');

        return Command::SUCCESS;
    }
}

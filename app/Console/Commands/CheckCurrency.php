<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\CurrencyHistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckCurrency extends Command
{
    protected $signature = 'check:currency';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $response = Http::get('http://api.currencylayer.com/live?access_key=d324aae15bd9db38162ce31eb376c241');

        $this->updateHistory();
        Currency::truncate();

        foreach ($response->json()['quotes'] as $key => $value) {
            Currency::create([
                'source' => $key,
                'quote' => $value
            ]);
        }
    }

    private function updateHistory()
    {
        foreach (Currency::all() as $currency) {
            CurrencyHistory::create([
                'source' => $currency->source(),
                'quote' => $currency->quote()
            ]);
        }
    }
}

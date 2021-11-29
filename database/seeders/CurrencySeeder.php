<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use File;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        Currency::truncate();

        $json = File::get("database/data/currency.json");

        $currencies = json_decode($json);

        foreach ($currencies['quotes'] as $key => $value) {
            Currency::create([
                'source' => $key,
                'quote' => $value
            ]);
        }
    }
}

<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;

class CurrencyService
{
    public function convert(float $value, string $from, string $to): array|null
    {
        if ($from == 'USD') {
            return $this->currencyFromUSD($value, $to);
        } elseif ($to == 'USD') {
            return $this->currencyToUSD($value, $from);
        }
        return $this->currencyFromOtherSource($value, $from, $to);
    }

    public function convertToMultipleSource(float $value, string $from, array $to): array
    {
        $values = [];
        foreach ($to as $val) {
            array_push($values, $this->convert($value, $from, $val));
        }
        return $values;
    }

    private function currencyFromUSD(float $value, string $to): array|null
    {
        $source = 'USD'.$to;
        $currency = Currency::where('source', $source)->first();
        if ($currency) {
            return [
                $to =>  $currency->quote() * $value
            ];
        }
        return null;
    }

    private function currencyToUSD(float $value, string $from): array|null
    {
        $source = 'USD'.$from;
        $currency = Currency::where('source', $source)->first();
        if ($currency) {
            return [
            'USD' =>  $value / $currency->quote()
            ];
        }
        return null;
    }

    private function currencyFromOtherSource(float $value, string $from, string $to): array|null
    {
        $source1 = 'USD'.$from;
        $currency1 = Currency::where('source', $source1)->first();

        if (!$currency1) {
            return null;
        }

        $value1 = $currency1->quote() * $value;

        $source2 = 'USD'.$to;
        $currency2 = Currency::where('source', $source2)->first();

        if (!$currency2) {
            return null;
        }

        return [
            $to => $currency2->quote() * $value1
        ];
    }
}

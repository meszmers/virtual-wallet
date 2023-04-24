<?php

namespace App\Services;

use App\Models\Currency;

class CurrenciesService
{
    /**
     * @param int $currencyId
     * @param string $currencyCode
     * @return bool
     */
    public function currencyIsValid(int $currencyId, string $currencyCode): bool
    {
        return !!Currency::where([['id', $currencyId], ['currency_code', $currencyCode]])->first();
    }

    /**
     * @return array
     */
    public function getCurrencies(): array
    {
        return Currency::all()->toArray();
    }
}

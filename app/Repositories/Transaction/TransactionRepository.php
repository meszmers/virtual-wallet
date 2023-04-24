<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;

interface TransactionRepository
{
    public function index(int $userId, string $walletNumber);

    public function create(string $walletNumber, float $amount, int $currencyId, ?string $toWalletNumber): Transaction;
}

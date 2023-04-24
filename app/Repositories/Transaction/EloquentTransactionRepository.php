<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;

class EloquentTransactionRepository implements TransactionRepository
{

    public function index(int $userId, string $walletNumber)
    {
        return Transaction::where('wallet_number', $walletNumber)->paginate(10, ['*'], 'transaction_page');
    }

    public function create(string $walletNumber, float $amount, int $currencyId, ?string $toWalletNumber): Transaction
    {
        return Transaction::create([
            'wallet_number' => $walletNumber,
            'amount' => $amount,
            'to_wallet_number' => $toWalletNumber,
            'currency_id' => $currencyId,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

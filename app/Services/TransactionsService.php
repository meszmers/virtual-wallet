<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;

class TransactionsService
{
    private CurrenciesService $currenciesService;

    public function __construct(CurrenciesService $currenciesService)
    {
        $this->currenciesService = $currenciesService;
    }

    /**
     * @param string $walletNumber
     * @return array
     */
    public function getWalletTotalBalanceOfEachCurrency(string $walletNumber): array
    {
        $data = [];
        $currencies = $this->currenciesService->getCurrencies();

        foreach ($currencies as $currency) {
            $data[$currency['currency_code']] = Transaction::where([
                ['wallet_number', $walletNumber],
                ['currency_id', $currency['id']]
            ])->sum('amount');

            $data[$currency['currency_code']] += abs(Transaction::where([
                ['to_wallet_number', $walletNumber],
                ['currency_id', $currency['id']]
            ])->sum('amount'));
        }

        return $data;
    }

    public function isTransactionValid(int $senderUserId, string $walletNumber, float $amount, string $currencyCode, ?string $walletNumberTo): bool
    {
        // Can't make transaction on 0 amount(nothing changes)
        if ($amount == 0) {
            return false;
        }

        $senderWallet = Wallet::where('wallet_number', $walletNumber)->first();

        // Cannot set transaction to non-existing wallet
        if (!$senderWallet) {
            return false;
        }

        // Transaction can be made only from your wallets.
        if ($senderWallet['user_id'] !== $senderUserId) {
            return false;
        }

        if ($walletNumberTo) {
            $walletToExists = Wallet::where('wallet_number', $walletNumberTo)->first();

            // Cannot set transaction to non-existing wallet
            if (!$walletToExists) {
                return false;
            }
        }

        $balanceOfEachCurrency = $this->getWalletTotalBalanceOfEachCurrency($walletNumber);

        // Can't make transactions to other currencies
        if (empty($balanceOfEachCurrency[$currencyCode])) {
            return false;
        }

        // Can't receive money from other wallets by request
        if ($walletNumberTo && $amount > 0) {
            return false;
        }

        // Balance needs to be higher than amount when sending to other wallet
        if ($walletNumberTo && $amount > $balanceOfEachCurrency[$currencyCode]) {
            return false;
        }

        // Can't withdraw more money than you have
        if (!$walletNumberTo && $amount < 0 && ($balanceOfEachCurrency[$currencyCode] + $amount) < 0) {
            return false;
        }

        return true;
    }
}

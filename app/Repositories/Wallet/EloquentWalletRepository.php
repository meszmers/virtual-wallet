<?php

namespace App\Repositories\Wallet;

use App\Models\Wallet;
use Illuminate\Support\Str;

class EloquentWalletRepository implements WalletRepository
{

    /**
     * @param int $userId
     * @return mixed
     */
    public function index(int $userId): mixed
    {
        return Wallet::where('user_id', $userId)->paginate();
    }

    /**
     * @param int $userId
     * @param int $walletId
     * @return ?Wallet
     */
    public function show(int $userId, string $walletNumber): ?Wallet
    {
        return Wallet::where([
            ['wallet_number', $walletNumber],
            ['user_id', $userId]
        ])->first();
    }

    /**
     * @param int $userId
     * @param string $cardName
     * @return Wallet
     * @throws \Exception
     */
    public function create(int $userId, string $cardName): Wallet
    {
        return Wallet::create([
            'wallet_number' => Str::random(20),
            'user_id' => $userId,
            'card_name' => $cardName,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * @param int $userId
     * @param string $walletNumber
     * @return void
     */
    public function delete(int $userId, string $walletNumber)
    {
        Wallet::where([
            ['wallet_number', $walletNumber],
            ['user_id', $userId]
        ])->first()->delete();
    }

    /**
     * @param int $userId
     * @param string $walletNumber
     * @param string $newName
     * @return ?Wallet
     */
    public function update(int $userId, string $walletNumber, string $newName): ?Wallet
    {
        $wallet = Wallet::where([
            'wallet_number' => $walletNumber,
            'user_id' => $userId,
        ])->first();

        if ($wallet) {
            $wallet->card_name = $newName;
            $wallet->updated_at = now();

            $wallet->save();

            return $wallet;
        }
        return null;
    }
}

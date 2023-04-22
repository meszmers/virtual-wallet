<?php

namespace App\Repositories\Wallet;

use App\Models\Wallet;

interface WalletRepository
{
    /**
     * @param int $userId
     * @return mixed
     */
    public function index(int $userId);

    /**
     * @param int $userId
     * @param int $walletId
     * @return Wallet
     */
    public function show(int $userId, int $walletId): Wallet;

    /**
     * @param int $userId
     * @param string $cardName
     * @return Wallet
     */
    public function create(int $userId, string $cardName): ?Wallet;

    /**
     * @param int $userId
     * @param int $walletId
     * @return mixed
     */
    public function delete(int $userId, int $walletId);

    /**
     * @param int $userId
     * @param int $walletId
     * @param string $newName
     * @return ?Wallet
     */
    public function update(int $userId, int $walletId, string $newName): ?Wallet;

}

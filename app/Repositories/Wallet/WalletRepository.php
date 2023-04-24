<?php

namespace App\Repositories\Wallet;

use App\Models\Wallet;

interface WalletRepository
{
    /**
     * @param int $userId
     * @return mixed
     */
    public function index(int $userId): mixed;

    /**
     * @param int $userId
     * @param string $walletNumber
     * @return ?Wallet
     */
    public function show(int $userId, string $walletNumber): ?Wallet;

    /**
     * @param int $userId
     * @param string $cardName
     * @return ?Wallet
     */
    public function create(int $userId, string $cardName): ?Wallet;

    /**
     * @param int $userId
     * @param string $walletNumber
     * @return mixed
     */
    public function delete(int $userId, string $walletNumber);

    /**
     * @param int $userId
     * @param string $walletNumber
     * @param string $newName
     * @return ?Wallet
     */
    public function update(int $userId, string $walletNumber, string $newName): ?Wallet;

}

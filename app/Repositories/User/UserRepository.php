<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepository
{
    /**
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): ?User;

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    public function createUser(string $name, string $email, string $password): User;
}

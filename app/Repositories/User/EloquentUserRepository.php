<?php

namespace App\Repositories\User;

use App\Models\User;

class EloquentUserRepository implements UserRepository
{

    /**
     * @param string $email
     * @return ?User
     */
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    public function createUser(string $name, string $email, string $password): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);
    }
}

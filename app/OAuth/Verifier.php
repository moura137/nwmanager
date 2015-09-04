<?php

namespace NwManager\OAuth;

use Illuminate\Support\Facades\Auth;

/**
 * Class Verifier
 *
 * @package NwManager\OAuth
 */
class Verifier
{
    /**
     * Verify Password and Auth
     *
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::id();
        }

        return false;
    }
}
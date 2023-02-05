<?php

namespace Wallet\Services;

use Psr\Http\Message\ServerRequestInterface;

class AuthService
{
    /**
     * Auth place
     *
     * @return string[]
     */
    public function auth(ServerRequestInterface $request): array
    {
        //do something to get user and roles
        $_auth = $request;
        return ['user' => '1', 'role' => 'admin'];
    }
}